{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = "$usuario->nombre $usuario->apellido";
@endphp

{{-- Contenido --}}
@section('contenido')
    <div class="form-corto" id="formUsuario">
        @include('usuarios.campos-basicos',$campos=['subtitulos', 'id', 'cambiar_contraseñas', 'contraseñas'])
    </div>
@endsection

{{-- JavaScript --}}
@section('js')
    <script>
        var registrosP      = @json([$usuario]),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );
            llenarFormulario(0, "#formUsuario");
    </script>
@endsection