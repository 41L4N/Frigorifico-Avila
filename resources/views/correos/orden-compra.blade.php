@extends('correos.plantilla')
@section('contenido')
    <div style="text-align: left;">
        <h3 style="text-align: center">{{__('textos.titulos.nueva_orden_compra')}}</h3>
        <b>{{__('textos.campos.codigo')}}: </b>{{$ordenCompra->codigo}}
        <br>
        <b>{{__('textos.campos.fecha')}}: </b>{{formatos('f', $ordenCompra->created_at)}}        
        <h4 style="background: rgb(148, 2, 2); color: white; padding: 5px; margin: 7.5px 0px;">{{__('textos.titulos.usuario')}}</h4>
        <b>{{__('textos.campos.nombre_apellido')}}: </b>{{"$usuario->nombre $usuario->apellido"}}
        <br>
        <b>{{__('textos.campos.email')}}: </b>{{$usuario->email}}        
        @if ($datosF = $ordenCompra->datos_facturacion)
            <h4 style="background: rgb(148, 2, 2); color: white; padding: 5px; margin: 7.5px 0px;">{{__('textos.titulos.datos_facturacion')}}</h4>
            @foreach (json_decode($datosF) as $clave => $valor)
                <b>{{__('textos.campos.' . $clave)}} : </b> {{$valor}}
                @if (!$loop->last)
                    <br>
                @endif
            @endforeach            
        @endif
        <h4 style="background: rgb(148, 2, 2); color: white; padding: 5px; margin: 7.5px 0px;">{{__('textos.titulos.lista_compras')}}</h4>
        <table style="width: 100%; text-align: center;">
            <tr style="background: rgb(148, 2, 2); color: white;">
                <th>#</th>
                <th>{{__('textos.campos.producto')}}</th>
                <th>{{__('textos.campos.precio')}}</th>
                <th>{{__('textos.campos.cantidad')}}</th>
                <th>{{__('textos.campos.subtotal')}}</th>
            </tr>
            @foreach (json_decode($ordenCompra->productos) as $p)
                <tr>
                    <th>{{$loop->iteration}}</th>
                    <td>
                        {{$p->titulo}}
                        {{-- <br>
                        <img src="{{route('mostrar-img', [$p->tipo, $p->id])}}" alt="{{$p->alias}}" style="width: 75px;"> --}}
                    </td>
                    <td>
                        @if (isset($p->oferta) && $p->oferta)
                            <del>{{ formatos('n', $p->precio_detal, true) }}</del>
                            <br>
                            {{ formatos('n', $p->precio_unitario, true) }} (- {{ $p->oferta }} )
                        @else
                            {{ formatos('n', $p->precio_unitario, true) }}
                        @endif
                    </td>
                    <td>{{$p->cantidad}}</td>
                    <td>{{$p->subtotal}}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3"></th>
                <th style="text-align: right;">{{__('textos.campos.subtotal')}}</th>
                <th>{{formatos('n', $ordenCompra->total, true)}}</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th style="text-align: right;">{{__('textos.campos.cupon')}}</th>
                <th>{{ ($ordenCompra->cupon && $cupon = json_decode($ordenCompra->cupon) ) ? $cupon->oferta . "% ($cupon->codigo)" : "-" }}</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th style="text-align: right;">{{__('textos.campos.total')}}</th>
                <th>{{formatos('n', $ordenCompra->total - ( (isset($cupon)) ? $cupon->oferta * $ordenCompra->total / 100 : 0 ), true)}}</th>
            </tr>
        </table>
        @if ($direccionE = $ordenCompra->direccion_envio)
            <h4 style="background: rgb(148, 2, 2); color: white; padding: 5px; margin: 7.5px 0px;">{{__('textos.campos.direccion_envio')}}</h4>
            @foreach (json_decode($direccionE) as $clave => $valor)
                <b>{{__('textos.campos.' . $clave)}} : </b>{{$valor}}
                @if (!$loop->last)
                    <br>
                @endif
            @endforeach            
        @endif
        @if ($notas = $ordenCompra->notas)
            <h4 style="background: rgb(148, 2, 2); color: white; padding: 5px; margin: 7.5px 0px;">{{__('textos.campos.notas')}}</h4>
            {!! nl2br($notas) !!}
        @endif
    </div>
@endsection