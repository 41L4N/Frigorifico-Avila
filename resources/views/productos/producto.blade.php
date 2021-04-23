{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    // Variable corta porque el nombre largo es muy ladilla
    $p = $producto;
    $tituloMD = $p->titulo;
    $descripcionMD = $p->descripcion;
    $imgMD = route('mostrar-img', [$p->getTable(), $p->id]);
@endphp

{{-- Estilos --}}
@section('estilos')
    <style>

        /* Imagen */
        .cont-img-p {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 500px;
            aspect-ratio: 1 / 1;
            margin-right: 25px;
        }
        .cont-img-p img {
            max-width: 100%;
            max-height: 100%;
        }

        /* Información */
        .informacion-p > *:not(:last-child) {
            margin-bottom: 12.5px;
        }

        /* Titulo */
        .informacion-p .titulo { font-size: 27.5px; }

        /* Subtitulo */
        .informacion-p .subtitulo { font-size: 22.5px; }

        /* Precios */
        .informacion-p .precio-oferta {
            color: var(--c-plantilla);
            font-size: 22.5px;
        }
        .informacion-p .precio-oferta del {
            color: grey;
            font-size: initial;
        }

        /* Formulario de compras */
        .informacion-p .form-compras { max-width: 250px; }

        /* Redes sociales */
        .informacion-p .redes-sociales a {
            color: black;
            font-size: 27.5px;
            text-decoration: none;
            margin-right: 25px;
        }
        .informacion-p .redes-sociales a:hover {
            color: var(--c-plantilla);
        }

        /* Responsive */
        @media only screen and (max-width: 768px) {

            /* Contenedor principal */
            .cont-informacion-p {
                flex-direction: column;
                align-items: center;
            }

            /* Imagen */
            .cont-img-p {
                margin-right: unset;
                margin-bottom: 25px;
            }

            /* Información */
            /* Formulario de compras */
            .informacion-p .form-compras { max-width: unset; }

            /* Redes sociales */
            .informacion-p .redes-sociales {
                margin-top: 50px;
                text-align: center;
            }
        }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')
    <div class="d-flex cont-informacion-p">

        {{-- Imagen --}}
        <div class="cont-img-p">
            <img src="{{$imgMD}}" alt="{{config('app.name') . " " . $p->alias()}}">
        </div>

        {{-- Información --}}
        <div class="d-flex flex-column justify-content-around w-100 informacion-p">

            <div>
                {{-- Titulo --}}
                <div class="titulo">{{$p->titulo}}</div>
                {{-- Descripción --}}
                <div>{!! nl2br($p->descripcion) !!}</div>
            </div>

            {{-- Precios --}}
            {{-- Al detal --}}
            @if ($p->precio_detal)
                <div>
                    <div class="subtitulo">{{__('textos.titulos.compra_detal')}}</div>
                    <div>
                        <div class="precio-oferta">
                            @if ($p->oferta)
                                <del>{{ ( $precio = $p->precioOfertaP() )['precio'] }}</del>
                                <br>
                                {{$precio['oferta']}}
                            @else
                                {{ formatos('n', $p->precio_detal, true) }}
                            @endif
                        </div>
                        <b>{{__('textos.campos.pedido_min')}}:</b> {{$p->pedido_min_detal}}
                    </div>
                </div>
            @endif

            {{-- Al mayor --}}
            @if ($p->pedido_min_mayor && $p->precio_mayor)
                <div>
                    <div class="subtitulo">{{__('textos.titulos.compra_mayor')}}</div>
                    <div class="precio-oferta">{{formatos('n', $p->precio_mayor, true)}}</div>
                    <b>{{__('textos.campos.pedido_min')}}:</b> {{$p->pedido_min_mayor}}
                </div>
            @endif

            {{-- Precio --}}
            @if ($p->precio)
                <div>
                    <div class="subtitulo">{{__('textos.campos.precio')}}</div>
                    <div class="precio-oferta">{{formatos('n', $p->precio, true)}}</div>
                </div>
            @endif

            {{-- Lista de productos --}}
            @if ($p->productos)
                <div>
                    <div class="subtitulo">{{__('textos.campos.productos')}}</div>
                    @foreach ($p->productos as $producto)
                        <a href="{{route('productos', [$producto->alias(), $producto->id])}}">{{$producto->titulo}}</a>
                        ({{"$producto->cantidad $producto->unidad_medida"}}) <br>
                    @endforeach
                </div>
            @endif

            {{-- Compras --}}
            <form action="{{route('lista-compras')}}" method="POST" class="fila-form form-compras producto-lista-productos" onsubmit="event.preventDefault(); actualizarListaCompras(event.target)">
                @csrf
                <input type="hidden" name="accion" value="0">
                <input type="hidden" name="tipo" value="{{$p->getTable()}}">
                <input type="hidden" name="id" value="{{$p->id}}">
                <input type="number" name="cantidad" class="form-control" min="{{$min=1}}" max="99999" value="{{$min}}" onkeypress="soloNumeros(event)" required>
                <button class="btn btn-primary"><i class="fas fa-cart-plus mr-2"></i>{{__('textos.botones.comprar')}}</button>
            </form>

            {{-- Redes sociales --}}
            <div class="redes-sociales">
                <a href="https://www.facebook.com/sharer.php?u={{$ruta = request()->url()}}" target="_blank" class="fab fa-facebook-f"></a>
                <a href="https://twitter.com/share?url={{$ruta}}/&text={{urlencode($p->titulo)}}" target="_blank" class="fab fa-twitter"></a>
                <a href="mailto:yourfriend@email.com?subject={{urlencode($p->titulo)}}&body={{$ruta}}/" target="_blank" class="fas fa-envelope"></a>
            </div>
        </div>
    </div>
@endsection