<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuario;
use App\Models\OrdenCompra;
use App\Models\Cupon;
use Barryvdh\DomPDF\Facade as PDF;

class OrdenCompraCtrl extends Controller
{

    // Registros
    public function registros($id=null){

        // Vista en PDF
        if ($id && $oC = OrdenCompra::find($id)) {
            if (!Auth::user()->administrador || $oC->id_usuario != Auth::user()->id) {
                return back();
            }
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('correos.orden-compra', [
                'asunto'        => __('textos.titulos.nueva_orden_compra'),
                'usuario'       => Usuario::find($oC->id_usuario),
                'ordenCompra'   => $oC
            ]);
            return $pdf->stream("orden_compra_$oC->codigo.pdf");
        }

        // Lista de registros
        return view('ordenes-compras.ordenes-compras')->with([
            'ordenesCompras' => OrdenCompra::all()
        ]);
    }

    // Lista de compras
    public function lista(Request $rq){

        // Validación
        $rq->validate([
            'accion'        => 'required|digits:1|digits_between:0,2',
            'tipo'          => 'required|string',
            'id'            => 'required|integer',
            'cantidad'      => 'required|min:1',
        ]);

        // Lista actual
        $listas = ($lC = Cache::get($nombreCache = 'listas-compras')) ? $lC : [];
        $iListaActual = listaCompras()['i'];

        // Producto actual
        $iProductoActual = null;
        if ($iListaActual !== null) {
            foreach ($listas[$iListaActual]['productos'] as $iC => $c) {
                if ($c['tipo'] == $rq->tipo && $c['id'] == $rq->id) {
                    $iProductoActual = $iC;
                }
            }
        }

        // Acción
        switch ($rq->accion) {
            // Agregar
            case 0:

                // Nueva lista
                if ($iListaActual === null) {
                    array_push($listas, [
                        'ip'            => request()->ip(),
                        'id_usuario'    => (Auth::check()) ? Auth::user()->id : null,
                        'productos'     => []
                    ]);
                    $iListaActual = array_key_last($listas);
                }

                // Nuevo producto
                if ($iProductoActual === null) {
                    array_push($listas[$iListaActual]['productos'], [
                        'tipo'      => $rq->tipo,
                        'id'        => $rq->id,
                        'cantidad'  => $rq->cantidad
                    ]);
                    $iProductoActual = array_key_last($listas[$iListaActual]['productos']);
                }
                // O sumar cantidades
                else {
                    $cantidad = $listas[$iListaActual]['productos'][$iProductoActual]['cantidad'];
                    $listas[$iListaActual]['productos'][$iProductoActual]['cantidad'] = $cantidad + $rq->cantidad;
                }
            break;
            // Editar
            case 1:
                if ($iProductoActual !== null) {
                    $listas[$iListaActual]['productos'][$iProductoActual]['cantidad'] = $rq->cantidad;
                }
            break;
            // Eliminar
            case 2:
                if ($iProductoActual !== null) {
                    unset($listas[$iListaActual]['productos'][$iProductoActual]);
                    $listas[$iListaActual]['productos'] = array_values($listas[$iListaActual]['productos']);
                }
            break;
        }
        Cache::put($nombreCache, $listas);

        // Respuesta
        return response( listaCompras()['lista'] );
    }

    // Orden
    public function orden($id=null){
        if ($id && !ordenCompra::find($id)) {
            return back();
        }
        return view('ordenes-compras.orden-compra')->with([
            'idOrdenCompra' => $id
        ]);
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'cantidad'          => 'required|digits_between:1,5|min:1',
            'datos_facturacion' => "sometimes|array",
            'direccion_envio'   => "sometimes|array",
            'forma_pago'        => "required",
            'notas'             => "nullable",
            'cupon'             => "nullable|exists:cupones,codigo"
        ]);

        // Validacion del cupon
        if ( ( $cupon = Cupon::where('codigo', $rq->cupon)->where('estatus', true)->first() ) && $cupon->fecha_vencimiento < today()->toDateString()) {
            return back()->with([
                'alerta' => [
                    'tipo'  => 'danger',
                    'texto' => __('textos.alertas.cupon_vencido')
                ]
            ]);
        }

        // Lista
        $listaActual = listaCompras(true);

        // Registro
        $reg = new OrdenCompra;
        $reg->id_usuario = Auth::user()->id;
        $reg->codigo = uniqid();
        $reg->datos_facturacion = ($dF = $rq->datos_facturacion) ? json_encode($dF) : null;
        $reg->direccion_envio = ($dE = $rq->direccion_envio) ? json_encode($dE) : null;
        $reg->productos = json_encode($listaActual['lista']['productos']);
        $reg->cupon = ($cupon) ? json_encode($cupon) : null;
        $total = $listaActual['lista']['total']['numero'];
        $reg->total = $total - ( ($cupon) ? $cupon->oferta * $total / 100 : 0 );
        $reg->notas = $rq->notas;
        // $reg->save();
        if ($cupon) {
            $cupon->update(['estatus' => false]);
        }

        if ($rq->forma_pago == 'Mercado Pago') {
            \MercadoPago\SDK::setAccessToken("APP_USR-4700521719044381-073017-63279c70399d5f740ea1a6c9fc2207cc-377450564");
            $payment = new \MercadoPago\Payment();
            $payment->transaction_amount = (float) $reg->total;
            $payment->token = $_POST['token'];
            $payment->description = $reg->notas;
            $payment->installments = (int)$_POST['installments'];
            $payment->payment_method_id = $_POST['paymentMethodId'];
            $payment->issuer_id = (int)$_POST['issuer'];
            $payer = new \MercadoPago\Payer();
            $payer->email = $_POST['email'];
            $payer->identification = array(
                "type" => $_POST['docType'],
                "number" => $_POST['docNumber']
            );
            $payment->payer = $payer;
            $payment->save();
        }

        // Notificación
        // Mail::send("correos.orden-compra", [
        //     'asunto'        => $asunto = __('textos.titulos.nueva_orden_compra'),
        //     'usuario'       => Auth::user(),
        //     'ordenCompra'   => $reg
        // ], function($m) use ($rq, $asunto){
        //     $m->to("avilafrigorifico@gmail.com");
        //     $m->subject($asunto);
        // });

        // Respuesta
        // return redirect()->route('usuario.orden-compra', $reg->id);
    }
}