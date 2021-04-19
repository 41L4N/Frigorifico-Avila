{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = "$usuario->nombre $usuario->apellido";
@endphp

{{-- Contenido --}}
@section('contenido')
    <form action="" method="POST" class="form-corto" id="formUsuario">
        @csrf

        {{-- Campos --}}
        @include('usuarios.campos-basicos',$campos=['subtitulos', 'id', 'cambiar_contraseñas', 'contraseñas'])

        {{-- Botones --}}
        <div class="btns-form">
            <button class="btn btn-primary">{{__('textos.botones.enviar')}}</button>
        </div>
    </form>
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