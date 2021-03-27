{{-- Plantilla --}}
@extends('plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.'.prefijo());
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
@endsection

{{-- Contenido --}}
@section('contenido')
    <div class="cont-miniaturas">

        {{-- Rutas --}}
        @foreach (['roles','usuarios',] as $r)
            <a href="{{route($r)}}" class="miniatura">
                <i class="{{iconos($r)}}"></i>
                <div class="titulo-miniatura">{{__('textos.rutas.'.$r)}}</div>
            </a>
        @endforeach
    </div>
@endsection