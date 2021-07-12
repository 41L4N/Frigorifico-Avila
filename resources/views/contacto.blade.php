{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = "Contacto";
@endphp

{{-- Estilos --}}
@section('estilos')
    <style>

    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <form method="POST" class="form-corto">
        @csrf

        {{-- Nombre y Apellido --}}
        <div class="fila-form">
            <div>
                <label>{{__('textos.campos.' . $n="nombre")}}</label>
                <input name="{{$n}}" class="form-control" required>
            </div>
            <div>
                <label>{{__('textos.campos.' . $n="apellido")}}</label>
                <input name="{{$n}}" class="form-control" required>
            </div>
        </div>

        {{-- Email y teléfono--}}
        <div class="fila-form">
            <div>
                <label>{{__('textos.campos.' . $n="email")}}</label>
                <input type="email" name="{{$n}}" class="form-control" required>
            </div>
            <div>
                <label>{{__('textos.campos.' . $n="telf")}}</label>
                <input name="{{$n}}" class="form-control" required>
            </div>
        </div>

        {{-- Mensaje --}}
        <div class="fila-form">
            <div>
                <label>{{__('textos.campos.' . $n="mensaje")}}</label>
                <textarea name="{{$n}}" class="form-control" required></textarea>
            </div>
        </div>

        {{-- Botones --}}
        <div class="btns-form">
            <button class="btn btn-primary">{{__('textos.botones.enviar')}}</button>
        </div>
    </form>
@endsection

{{-- JavaScript --}}
@section('js')
    <script>

    </script>
@endsection