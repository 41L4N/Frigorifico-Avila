{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
    <style>

    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <div class="d-flex">

        Filtros

        <div class="cont-mins align-content-center">
    
            {{-- Rutas --}}
            @foreach ($productos as $p)
                @include('productos.miniatura')
            @endforeach
        </div>
    </div>
@endsection