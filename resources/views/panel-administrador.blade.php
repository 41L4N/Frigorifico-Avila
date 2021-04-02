{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . prefijo("_"));
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
    <style>
        .min i { font-size: 50px }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <div class="cont-mins align-content-center">

        {{-- Rutas --}}
        @foreach (['roles', 'usuarios', 'filtros-productos', 'inventario'] as $r)
            <a href="{{route($r)}}" class="min">
                <div class="contenido-min">
                    <i class="{{iconos($r)}}"></i>
                    <div class="titulo-min">{{__('textos.rutas.' . str_replace('-', '_', $r) )}}</div>
                </div>
            </a>
        @endforeach
    </div>
@endsection