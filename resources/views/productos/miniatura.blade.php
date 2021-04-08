{{-- Estilos --}}
@once
    @section('estilos')
        <style>
            .min-p {
                max-width: calc(100% / 5.5);
            }
        </style>
    @append
@endonce

{{-- Contenido --}}
<a href="{{route('productos', [$p->alias(), $p->id])}}" class="min @if($p->oferta) oferta @endif min-p">

    {{-- Etiquetas --}}
    <div class="cont-etiquetas-min">
        
    </div>

    {{-- Imagen --}}
    <div class="cont-img-min">
        <img src="{{route('mostrar-img', [$p->getTable(), $p->id])}}" alt="{{config('app.name') . " " . $p->titulo}}">
    </div>

    {{-- Información --}}
    <div class="contenido-min">

        {{-- Título --}}
        <div class="titulo-min">{{$p->titulo}}</div>

        {{-- Precios --}}
        {{-- Al detal --}}
        <div class="precio-oferta-min">
            @if ($p->oferta)
                <del>{{$p->precioOfertaP()['precio']}}</del>
                <br>
                <b>{{$p->precioOfertaP()['oferta']}}</b>
            @else
                <b>{{$p->precioOfertaP()['precio']}}</b>
            @endif

            {{-- Al mayor --}}
            @if ($p->precio_mayor)
                <br>
                {{$p->precioMayorP()}} (Al mayor)
            @endif
        </div>
    </div>

    {{-- Boton de comprar --}}
</a>