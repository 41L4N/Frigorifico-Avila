{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
@endsection

{{-- Contenido --}}
@section('contenido')
    @foreach ($productos as $tipo => $ps)
        <div class="titulo-form">{{__('textos.titulos.' . $tipo)}}</div>
        <div class="cont-mins">
            @foreach ($ps as $p)
                @include('productos.miniatura')
            @endforeach
        </div>
    @endforeach
@endsection