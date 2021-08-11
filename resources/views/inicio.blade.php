{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/carrusel.css')}}">
    <link rel="stylesheet" href="{{asset('/css/miniaturas.css')}}">
    <style>
        .titulo-inicio {
            text-align: center;
            margin-top: .75em;
            color: var(--c-plantilla);
            font-weight: bolder;
        }

        /* Cuadros */
        .cont-cuadros {
            background: var(--c-plantilla);
            color: var(--c-l-plantilla);
            padding: 2.5%;
        }
        .cuadro {
            width: 100%;
            min-width: 250px;
            max-width: calc(100% / 3.5);
            text-align: center;
        }
        .cuadro i { font-size: 25px; }

        /* Responsive */
        @media only screen and (max-width: 768px) {

            /* Cuadros */
            .cont-cuadros {
                flex-wrap: wrap;
            }
        }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')

    {{-- Productos --}}
    @foreach ($productos as $tipo => $ps)
        <div class="titulo-form titulo-inicio">{{__('textos.titulos.' . $tipo)}}</div>
        <div class="carrusel">
            <div class="cont-items-carrusel">
                @foreach ($ps as $p)
                    @include('productos.miniatura')
                @endforeach
            </div>
            <i class="fas fa-chevron-left flecha-carrusel izquierda" onclick="moverCarrusel(this, '+')"></i>
            <i class="fas fa-chevron-right flecha-carrusel derecha" onclick="moverCarrusel(this, '-')"></i>
        </div>
    @endforeach
@endsection

{{-- JavaScript --}}
@section('js')
    <script src="{{asset('/js/carrusel.js')}}"></script>
@endsection