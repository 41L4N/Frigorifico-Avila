@foreach ($listaCompras as $c)
    <div action="{{route('lista-compras')}}" method="POST" class="producto-lista-compras">
        {{-- Acción --}}
        <input type="hidden" name="accion" value="1">
        {{-- Id de producto --}}
        <input type="hidden" name="id_producto" value="{{$c->id}}">
        {{-- Precio --}}
        <input type="hidden" name="precio_unitario" value="{{$c->precio_unitario}}" disabled>
        <b>{{$loop->iteration}}</b>
        {{-- Miniatura de imagen --}}
        <a href="{{$rutaP = route('productos', [$c->alias(), $c->id])}}" class="min-img">
            <img src="{{route('mostrar-img', [$c->getTable(), $c->id])}}" alt="{{config('app.name') ." " . $c->alias()}}">
        </a>
        {{-- Información --}}
        <div class="w-100">
            <a href="{{$rutaP}}">{{$c->titulo}}</a> ({{formatos('n', $c->precio_unitario, true)}})
            {{-- Cantidad --}}
            <input type="number" name="cantidad" class="form-control w-25" min="1" max="999" minlength="1" maxlength="6" value="1" value="{{$c->cantidad}}" onkeypress="soloNumeros(event)" onchange="listaCompras(this)">
            <b class="subtotal">{{formatos('n', $c->precio_unitario * $c->cantidad, true)}}</b>
        </div>
        <label class="btn btn-danger fas fa-times">
            <input type="checkbox" name="accion" class="d-none" value="2" onchange="listaCompras(this)">
        </label>
    </div>
@endforeach