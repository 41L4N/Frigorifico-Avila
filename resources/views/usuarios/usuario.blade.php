{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = "$usuario->nombre $usuario->apellido";
@endphp

{{-- Estilos --}}
@section('estilos')
    <style>
        
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <div class="form-corto">
        @include('usuarios.campos-basicos',$campos=['subtitulos', 'id', 'cambiar_contraseñas', 'contraseñas'])
    </div>
@endsection

{{-- JavaScript --}}
@section('js')
    <script>

    </script>
@endsection