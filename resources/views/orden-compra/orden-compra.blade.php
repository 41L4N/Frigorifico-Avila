{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    
@endphp

{{-- Estilos --}}
@section('estilos')
    <style>
        /* Dirección de envío */
        #direccionEnvio {
            max-height: 1000px;
            transition: .5s;
        }
        #direccionEnvio:disabled {
            max-height: 0px;
            overflow: hidden;
        }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <form method="POST">

        {{-- Información de facturación --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.informacion_facturacion')}}</div>
        {{-- Campos --}}
        @include('orden-compra.campos-informacion-facturacion', ['cPadre'=>''])

        {{-- Información de envio --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.informacion_envio')}}</div>
        {{-- Check --}}
        <div class="fila-form">
            <div>
                <label><input type="checkbox" name="direccion_envio" onchange="direccionEnvio.disabled = !direccionEnvio.disabled">{{__('textos.campos.direccion_diferente')}}</label>
            </div>
        </div>
        {{-- Campos --}}
        <fieldset id="direccionEnvio" disabled>
            @include('orden-compra.campos-informacion-facturacion', ['cPadre'=>'direccion_envio'])
        </fieldset>
        {{-- Notas --}}
        <div class="fila-form">
            <div>
                <label>{{__('textos.campos.notas_pedido')}}</label>
                <textarea name="informacion_envio" class="form-control" maxlength="500"></textarea>
            </div>
        </div>

        {{-- Lista de compras --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.lista_compras')}} (<span class="n-compras"></span>)</div>
        {{-- Compras --}}
        @include('plantillas.lista-compras')

        {{-- Lista de compras --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.forma_pago')}}</div>
    </form>
@endsection