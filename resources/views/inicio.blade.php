{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
@endsection

{{-- Contenido --}}
@section('contenido')

    {{-- Contenedor principal --}}
    <div class="d-flex">

        {{-- Productos --}}
        <div>
            @foreach ($productos as $tipo => $ps)
                <div class="titulo-form">{{__('textos.titulos.' . $tipo)}}</div>
                <div class="cont-mins">
                    @foreach ($ps as $p)
                        @include('productos.miniatura')
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- Panel lateral --}}


    </div>
@endsection