@extends('correos.plantilla')
@section('contenido')
    <table style="width: 100%">
        <tr>
            <th colspan="100%"><h2>{{__('textos.titulos.nueva_orden_compra')}}</h2></th>
        </tr>
        <tr>
            <th style="width: 50%">{{__('textos.campos.codigo')}}</th>
            <th style="width: 50%">{{__('textos.campos.fecha')}}</th>
        </tr>
        <tr>
            <td>{{$ordenCompra->codigo}}</td>
            <td>{{formatos('f', $ordenCompra->created_at)}}</td>
        </tr>
        <tr>
            <th colspan="100%"><h4>{{__('textos.titulos.usuario')}}</h4></th>
        </tr>
        <tr>
            <th>{{__('textos.campos.nombre_apellido')}}</th>
            <th>{{__('textos.campos.email')}}</th>
        </tr>
        <tr>
            <td>{{"$usuario->nombre $usuario->apellido"}}</td>
            <td>{{$usuario->email}}</td>
        </tr>
        @if ($datosF = $ordenCompra->datos_facturacion)
            <tr>
                <th colspan="100%"><h4>{{__('textos.titulos.datos_facturacion')}}</h4></th>
            </tr>
            <tr>
                <td>
                    @foreach (json_decode($datosF) as $clave => $valor)
                        <b>{{__('textos.campos.' . $clave)}} : </b> {{$valor}}
                        @if (!$loop->last)
                            <br>
                        @endif
                    @endforeach
                </td>
            </tr>
        @endif
        <tr>
            <th colspan="100%"><h4>{{__('textos.titulos.lista_compras')}}</h4></th>
        </tr>
        <tr>
            <td colspan="100%">
                <table style="width: 100%;">
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
                        <th colspan="100%">{{formatos('n', $ordenCompra->total, true)}}</th>
                    </tr>
                </table>
            </td>
        </tr>
        @if ($direccionE = $ordenCompra->direccion_envio)
            <tr>
                <th colspan="100%"><h4>{{__('textos.campos.direccion_envio')}}</h4></th>
            </tr>
            <tr>
                <td>
                    @foreach (json_decode($direccionE) as $clave => $valor)
                        <b>{{__('textos.campos.' . $clave)}} : </b> {{$valor}}
                        @if (!$loop->last)
                            <br>
                        @endif
                    @endforeach
                </td>
            </tr>
        @endif
        @if ($notas = $ordenCompra->notas)
            <tr>
                <th colspan="100%"><h4>{{__('textos.campos.notas')}}</h4></th>
            </tr>
            <tr>
                <td colspan="100%">{!! nl2br($notas) !!}</td>
            </tr>
        @endif
    </table>
@endsection