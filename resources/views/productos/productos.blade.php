{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . str_replace('-', '_', $nRuta = Route::currentRouteName()) );
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
@endsection

{{-- Contenido --}}
@section('contenido')
    <div class="cont-mins">

        {{-- Rutas --}}
        @foreach ($productos as $p)
            @include('productos.miniatura')
        @endforeach
    </div>
@endsection