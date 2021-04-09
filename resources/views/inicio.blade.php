{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
@endsection

{{-- Contenido --}}
@section('contenido')

    {{-- Carrusel --}}
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach ($isCarrusel as $i)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index}}" @if ($loop->first) class="active" @endif></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach ($isCarrusel as $i)
                <div class="carousel-item @if($loop->first) active @endif">
                    <img class="d-block w-100" src="{{route('mostrar-img', ['carrusel', $i])}}" alt="{{config('app.name')}}">
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    {{-- Productos --}}
    @foreach ($productos as $tipo => $ps)
        <div class="titulo-form">{{__('textos.titulos.' . $tipo)}}</div>
        <div class="cont-mins">
            @foreach ($ps as $p)
                @include('productos.miniatura')
            @endforeach
        </div>
    @endforeach
@endsection