{{-- Contenido --}}
<a href="{{route('productos', [$p->alias(), $p->id])}}" class="min">

    {{-- Etiquetas --}}
    <div class="cont-etiquetas-min">
        @foreach (['oferta', 'precio_mayor'] as $item)
            @if ($p->$item)
                <div class="etiqueta-min">{{ $p->$item }}</div>
            @endif
        @endforeach
    </div>

    {{-- Imagen --}}
    <img src="{{route('mostrar-img', [$p->getTable(), $p->id])}}" alt="{{config('app.name') . " " . $p->titulo}}" class="img-min">

    {{-- Información --}}
    <div class="contenido-min">

        {{-- Título --}}
        <div class="titulo-min">{{$p->titulo}}</div>

        {{-- Precio --}}
        <div class="precio-oferta-min {{($p->oferta) ? "oferta ": null}}">
            @if ($p->oferta)
                <del>{{$p->precioOfertaP()['precio']}}</del>
                <div>{{$p->precioOfertaP()['oferta']}}</div>
            @else
                <div>{{$p->precioOfertaP()['precio']}}</div>
            @endif
        </div>
    </div>

    {{-- Boton de comprar --}}
</a>