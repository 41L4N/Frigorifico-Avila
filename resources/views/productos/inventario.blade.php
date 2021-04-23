{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . str_replace('-', '_', Route::currentRouteName()) );
@endphp

{{-- Contenido --}}
@section('contenido')

    <form action="{{route(Route::currentRouteName() . '.eliminar')}}" method="POST" class="form-registros">
        @csrf

        {{-- Submenu --}}
        <div class="submenu-registros">
            <div>{{$tituloMD}}</div>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vtnGuardar">{{__('textos.botones.agregar')}}</button>
                <button type="button" class="btn btn-danger btn-admin" data-toggle="modal" data-target="#vtnConfirmacion" disabled>{{__('textos.botones.eliminar')}}</button>
            </div>
        </div>

        {{-- Registros --}}
        @if ($productos->count())

            {{-- Tabla de resultados --}}
            <table class="tb-registros">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(), contarChecks()'></th>
                    @foreach (['producto', 'filtro', 'precio_detal', 'oferta','precio_mayor'] as $campo)
                        <th>{!! __('textos.campos.' . $campo) !!}</th>
                    @endforeach
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($productos as $p)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="registros[]" onclick='contarChecks()' value="{{$p->id}}"></th>
                        <td>
                            <a href="{{$rutaP = route('productos', [$p->alias(), $p->id])}}">{{$p->titulo}}</a>
                            <br>
                            <a href="{{$rutaP}}" class="cont-min-img">
                                <img src="{{route('mostrar-img', [$p->getTable(), $p->id])}}" alt="{{config('app.name') . "  " . $p->titulo}}">
                            </a>
                        </td>
                        <td>{{$p->filtroP()}}</td>
                        <td>{{formatos('n', $p->precio_detal, true)}}</td>
                        <td>{{ ($p->oferta) ? $p->precioOfertaP()['oferta'] : "-" }}</td>
                        <td>{{ ($p->precio_mayor) ? $p->precioMayorP() : "-" }}</td>
                        <td><a class="fas fa-edit" href="" onclick="event.preventDefault(); llenarFormulario({{$loop->index}}, '#vtnGuardar')"></a></td>
                    </tr>
                @endforeach
            </table>

        {{-- Sin resultados --}}
        @else
            @include('plantillas.sin-resultados')
        @endif
    </form>

    {{-- Ventanas modales --}}
    {{-- Agregar --}}
    <div class="modal fade" id="{{$idVtn="vtnGuardar"}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{$tituloMD}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {{-- Campos --}}
                <div class="modal-body">

                    {{-- Ids --}}
                    <input type="hidden" name="id_vtn" value="{{$idVtn}}">
                    <input type="hidden" name="id">

                    {{-- Titulo y filtro --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='titulo')}}</label>
                            <input type="text" class="form-control" name="{{$n}}" maxlength="75" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='filtro')}}</label>
                            <select name="filtro" class="form-control">
                                <option value="" selected disabled>{{__('textos.placeholders.select')}}</option>
                                @foreach ($filtros as $f)
                                    @if ($f->opciones->count())
                                        <optgroup label="{{$f->titulo}}">
                                            @foreach ($f->opciones as $o)
                                                <option value="{{$o->id}}">{{$o->titulo}}</option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option value="{{$f->id}}">{{$f->titulo}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='unidad_medida')}}</label>
                            <select name="{{$n}}" class="form-control" required>
                                <option value="" selected required>{{__('textos.placeholders.select')}}</option>
                                @foreach (['Kg','Unidad', 'Gramo'] as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Compra al detal --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='pedido_min_detal')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="{{$min=1}}" max="99999" value="{{$min}}" onkeypress="soloNumeros(event)" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='precio_detal')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="{{$min=1}}" max="99999" value="{{$min}}" onkeypress="soloNumeros(event)" required>
                        </div>
                    </div>

                    {{-- Oferta --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='pedido_min_oferta')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="{{$min=0}}" max="99999" value="{{$min}}" onkeypress="soloNumeros(event)">
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='oferta')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="{{$min=0}}" max="100" value="{{$min}}" onkeypress="soloNumeros(event)">
                        </div>
                    </div>

                    {{-- Compra al mayor --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='pedido_min_mayor')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="{{$min=0}}" max="99999" onkeypress="soloNumeros(event)">
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='precio_mayor')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="{{$min=0}}" max="99999" onkeypress="soloNumeros(event)">
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n = 'descripcion')}}</label>
                            <textarea name="{{$n}}" class="form-control" maxlength="500"></textarea>
                        </div>
                    </div>

                    {{-- Imagen --}}
                    <div class="fila-form justify-content-center">
                        <label class="btn-actualizar-img">
                            <input type="file" name="img" accept="image/jpg,image/jpeg,image/png" onchange="vistaPreviaImg(this, this)" required>
                            <img>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('textos.botones.cancelar')}}</button>
                    <button class="btn btn-primary">{{__('textos.botones.enviar')}}</button>
                </div>
            </form>
        </div>
    </div>
    {{-- Confirmación --}}
    @include('plantillas.ventana-confirmacion')
@endsection

{{-- JavaScript --}}
@section('js')
    <script>
        var registrosP      = @json($productos),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );

        // Campos adicionales
        var inputImg = document.querySelector('[name="img"]')
        function camposAdicionales(llenar, contFormulario) {

            // Llenar
            if (llenar) {
                vistaPreviaImg(inputImg, '/img/productos/' + registroA.id)
                inputImg.required = false
            }

            // Vaciar
            else {
                document.querySelector('.btn-actualizar-img img').removeAttribute('src')
                inputImg.required = true
            }
        }
    </script>
@endsection