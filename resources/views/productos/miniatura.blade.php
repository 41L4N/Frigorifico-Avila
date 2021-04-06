{{-- Contenido --}}
<a href="{{route('productos', [$p->alias(), $p->id])}}" class="min @if($p->oferta) oferta @endif">

    {{-- Etiquetas --}}
    <div class="cont-etiquetas-min">
        
    </div>

    {{-- Imagen --}}
    <img src="{{route('mostrar-img', [$p->getTable(), $p->id])}}" alt="{{config('app.name') . " " . $p->titulo}}" class="img-min">

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