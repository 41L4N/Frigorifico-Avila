{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    
@endphp

{{-- Estilos --}}
@section('estilos')
    <style>

    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <form method="POST">

        {{-- Información de facturación --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.informacion_facturacion')}}</div>
        {{-- Campos --}}
        @php($cPadre="")
        @include('orden-compra.campos-informacion-facturacion')

        {{-- Información de envio --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.informacion_envio')}}</div>
        {{-- Check --}}
        <div class="fila-form">
            <div>
                <label><input type="checkbox" name="direccion_envio" onchange="">{{__('textos.campos.direccion_diferente')}}</label>
            </div>
        </div>
        {{-- Campos --}}
        <div id="camposDireccionEnvio">
            @php($cPadre='direccion_envio')
            @include('orden-compra.campos-informacion-facturacion')
        </div>
        {{-- Notas --}}
        <div class="fila-form">
            <div>
                <label>{{__('textos.campos.notas_pedido')}}</label>
                <textarea name="informacion_envio" class="form-control" maxlength="500"></textarea>
            </div>
        </div>

        {{-- Lista de compras --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.lista_compras')}}</div>
        {{-- Compras --}}
        <table class="tb-resultados">
            <tr>
                <th>#</th>
                <th>{{__('textos.campos.producto')}}</th>
                <th>{{__('textos.campos.cantidad')}}</th>
                <th>{{__('textos.campos.precio_unitario')}}</th>
                <th>{{__('textos.campos.subtotal')}}</th>
            </tr>
            @foreach ($listaCompras as $c)
                <tr>
                    <th>{{$loop->iteration}}</th>
                    <td>
                        <a href="{{$rutaP = route('productos', [$c->alias(), $c->id])}}">{{$c->titulo}}</a>
                        <br>
                        <a href="{{$rutaP}}" class="min-img">
                            <img src="{{route('mostrar-img',[$c->getTable(), $c->id])}}" alt="{{config('app.name') . "  " . $c->titulo}}">
                        </a>
                    </td>
                    <td>{{$c->cantidad}}</td>
                    <td>{{formatos('n', $c->precio_unitario, true)}}</td>
                    <td>{{formatos('n', $c->cantidad * $c->precio_unitario, true)}}</td>
                </tr>
            @endforeach
        </table>

        {{-- Lista de compras --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.forma_pago')}}</div>
    </form>
@endsection