@extends('correos.plantilla')
@section('contenido')
    <h3>{{__('textos.titulos.nueva_orden_compra')}}</h3>
    <h4>{{__('textos.titulos.usuario')}}</h4>
    {{"$usuario->nombre $usuario->apellido"}}
    <br>
    {{$usuario->email}}
    <h4>{{__('textos.titulos.lista_compras')}}</h4>
    <table style="width: 100%;">
        <tr style="background: var(--c-plantilla); color: var(--c-l-plantilla); ">
            <th>#</th>
            <th>{{__('textos.campos.producto')}}</th>
            <th>{{__('textos.campos.precio')}}</th>
            <th>{{__('textos.campos.cantidad')}}</th>
            <th>{{__('textos.campos.subtotal')}}</th>
        </tr>
        @foreach ($listaCompras['productos'] as $p)
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
            <th colspan="100%">{{$listaCompras['total']}}</th>
        </tr>
    </table>
@endsection