{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = "Carrusel";
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
    <link rel="stylesheet" href="{{asset('/css/arrastrar-soltar.css')}}">
    <style>
        .vp-img-carrusel {
            min-width: 300px;
            max-width: calc(100% / 2.5);
            height: 200px;
        }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Seleccionador de imágenes --}}
        <div class="cont-mins">
            @for ($i = 0; $i < 5; $i++)
                <label class="min btn-actualizar-img arrastrar-soltar vp-img-carrusel" draggable="true">
                    <input type="file" name="imgs_carrusel[]" accept="image/jpeg,image/jpg,image/png" onchange="vistaPreviaImg(this, this)">
                    <input type="hidden" name="is_imgs_carrusel[]" value="{{$i}}">
                    <img src='{{ (almacenImgs()->exists("carrusel_$i.json")) ? route('mostrar-img', ["carrusel", $i, 0, 750]) : "" }}'>
                </label>
            @endfor
        </div>

        {{-- Botones --}}
        <div class="btns-form">
            <button class="btn btn-primary">{{__('textos.botones.enviar')}}</button>
        </div>
    </form>
@endsection

{{-- JavaScript --}}
@section('js')
    <script src="{{asset('/js/arrastrar-soltar.js')}}"></script>
@endsection