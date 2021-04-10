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
        .cont-mins { flex: 1; }
        .btn-administrador { max-width: calc(100% / 3.5) }
        .min i { font-size: 50px; }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <div class="cont-mins align-content-center">

        {{-- Rutas --}}
        @foreach (['carrusel', 'roles', 'usuarios', 'filtros-productos', 'inventario', 'combos', 'cupones'] as $r)
            <a href="{{route($r)}}" class="min btn-administrador">
                <div class="contenido-min">
                    <i class="{{iconos($r)}}"></i>
                    <div>{{__('textos.rutas.' . str_replace('-', '_', $r) )}}</div>
                </div>
            </a>
        @endforeach
    </div>
@endsection