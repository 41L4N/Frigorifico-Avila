{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = "Productos";
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