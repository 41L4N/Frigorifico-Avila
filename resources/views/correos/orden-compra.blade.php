@extends('correos.plantilla')
@section('contenido')
    <div style="text-align: left">
        <h2 style="text-align: center">{{__('textos.titulos.nueva_orden_compra')}}</h2>
        <b>{{__('textos.campos.codigo')}}: </b>{{$ordenCompra->codigo}}
        <br>
        <b>{{__('textos.campos.fecha')}}: </b>{{formatos('f', $ordenCompra->created_at)}}        
        <h3 style="background: rgb(148, 2, 2); color: white; padding: 5px;">{{__('textos.titulos.usuario')}}</h3>
        <b>{{__('textos.campos.nombre_apellido')}}: </b>{{"$usuario->nombre $usuario->apellido"}}
        <br>
        <b>{{__('textos.campos.email')}}: </b>{{$usuario->email}}        
        @if ($datosF = $ordenCompra->datos_facturacion)
            <h3 style="background: rgb(148, 2, 2); color: white; padding: 5px;">{{__('textos.titulos.datos_facturacion')}}</h3>
            @foreach (json_decode($datosF) as $clave => $valor)
                <b>{{__('textos.campos.' . $clave)}} : </b> {{$valor}}
                @if (!$loop->last)
                    <br>
                @endif
            @endforeach            
        @endif
        <h3 style="background: rgb(148, 2, 2); color: white; padding: 5px;">{{__('textos.titulos.lista_compras')}}</h3>
        <table style="width: 100%; text-align: center;">
            <tr style="background: var(--c-plantilla); color: var(--c-l-plantilla); ">
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
                        <br>
                        <img src="{{route('mostrar-img', [$p->tipo, $p->id])}}" alt="{{$p->alias}}" style="width: 75px;">
                    </td>
                    <td>
                        @if (!$p->oferta)
                            {{ formatos('n', $p->precio_unitario, true) }}
                        @else
                            <del>{{ formatos('n', $p->precio_detal, true) }}</del>
                            <br>
                            {{ formatos('n', $p->precio_unitario, true) }} (- {{ $p->oferta }} )
                        @endif
                    </td>
                    <td>{{$p->cantidad}}</td>
                    <td>{{$p->subtotal}}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="100%"><h2>{{formatos('n', $ordenCompra->total, true)}}</h2></th>
            </tr>
        </table>
        @if ($direccionE = $ordenCompra->direccion_envio)
            <h3 style="background: rgb(148, 2, 2); color: white; padding: 5px;">{{__('textos.campos.direccion_envio')}}</h3>
            @foreach (json_decode($direccionE) as $clave => $valor)
                <b>{{__('textos.campos.' . $clave)}} : </b>{{$valor}}
                @if (!$loop->last)
                    <br>
                @endif
            @endforeach            
        @endif
        @if ($notas = $ordenCompra->notas)
            <h3 style="background: rgb(148, 2, 2); color: white; padding: 5px;">{{__('textos.campos.notas')}}</h3>
            {!! nl2br($notas) !!}
        @endif
    </div>
@endsection