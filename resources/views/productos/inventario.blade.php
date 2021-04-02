{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . prefijo('_'));
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/formularios.css')}}">
    <style>
        /* Vista previa */
        .vista-previa {
            position: relative;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 250px;
            border: solid var(--c-plantilla) 2.5px;
            aspect-ratio: 1 / 1;
            cursor: pointer;
            color: grey;
        }
        #inputImg {
            position: absolute;
            opacity: 0;
        }
        .vista-previa i {font-size: 50px;}
        .vista-previa div {
            position: absolute;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: none;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: var(--c-l-t-c-plantilla);
            background: var(--t-c-plantilla);
            font-size: 20px;
        }
        .vista-previa:hover div { display: flex; }
        .vista-previa img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')

    <form action="{{route(prefijo() . '.eliminar')}}" method="POST" class="form-resultados">
        @csrf

        {{-- Submenu --}}
        <div class="submenu-resultados">
            <div>{{$tituloMD}}</div>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vtnGuardar">{{__('textos.botones.agregar')}}</button>
                <button type="button" class="btn btn-danger btn-admin" data-toggle="modal" data-target="#vtnConfirmacion" disabled>{{__('textos.botones.eliminar')}}</button>
            </div>
        </div>

        {{-- Resultados --}}
        @if ($productos->count())

            {{-- Tabla de resultados --}}
            <table class="tb-resultados">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(), contarChecks()'></th>
                    @foreach (['titulo', 'filtro', 'precio_detal', 'precio_mayor'] as $campo)
                        <th>{!! __('textos.campos.' . $campo) !!}</th>
                    @endforeach
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($productos as $p)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="resultados[]" onclick='contarChecks()' value="{{$p->id}}"></th>
                        <td>
                            <a href="{{route('productos', [$p->alias(), $p->id])}}">{{$p->titulo}}</a>
                            <div class="cont-img-tb-resultados">
                                <img src="{{route('mostrar-img',[$p->getTable(), $p->id])}}" alt="{{config('app.name') . "  " . $p->titulo}}">
                            </div>
                        </td>
                        <td>{{$p->filtroP()}}</td>
                        <td>
                            @if ($p->oferta)
                                <del>{{ ( $precio = $p->precioOfertaP() )['precio'] }}</del>
                                <br>
                                {{$precio['oferta']}}
                            @else
                                {{ formatos('n', $p->precio_detal, true) }}
                            @endif
                        </td>
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
            <form class="modal-content" action="" method="POST" enctype="multipart/form-data">
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
                    </div>

                    {{-- Compra al detal --}}
                    <div class="fila-form">
                        {{-- Pedido mínimo --}}
                        <div>
                            <label>{{__('textos.campos.' . $n='pedido_min_detal')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="{{$min=1}}" value="{{$min}}" onkeypress="soloNumeros(event,5)" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='precio_detal')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="{{$min=1}}" value="{{$min}}" onkeypress="soloNumeros(event,5)" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='oferta')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" onkeypress="soloNumeros(event,5)">
                        </div>
                    </div>

                    {{-- Compra al mayor --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='pedido_min_mayor')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" onkeypress="soloNumeros(event,5)">
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='precio_mayor')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" onkeypress="soloNumeros(event,5)">
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n = 'descripcion')}}</label>
                            <textarea name="{{$n}}" class="form-control" maxlength="500"></textarea>
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="fila-form justify-content-center">
                        <label class="vista-previa">
                            <input type="file" id="inputImg" name="img" accept="image/jpg,image/jpeg,image/png" onchange="vistaPrevia()" required>
                            <i class="position-absolute fas fa-image"></i>
                            <img class="position-relative d-none">
                            <div>{{__('textos.campos.actualizar_img')}}</div>
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
        var registros       = @json($productos),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );

        // Campos adicionales
        function camposAdicionales(llenar, contFormulario) {

            // Llenar
            if (llenar) {
                vistaPrevia('/img/productos/' + registroA.id);
                inputImg.required = false;
            }

            // Vaciar
            else {
                img.removeAttribute('src');
                img.classList.add('d-none');
                inputImg.required = true;
            }
        }

        // Vista previa de imagen
        var img = document.querySelector('.vista-previa img');
        function vistaPrevia(ruta=null) {
            var archivo = inputImg.files[0];
            img.src = (ruta) ? ruta : (window.URL || window.webkitURL).createObjectURL(archivo);
            img.classList.remove('d-none');
        }
    </script>
    <script src="{{asset('/js/formularios.js')}}"></script>
@endsection