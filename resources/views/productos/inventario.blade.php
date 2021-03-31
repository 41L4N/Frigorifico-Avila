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
            width: 100%;
            height: 100%;
            object-fit: cover;
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
                    
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($productos as $u)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="resultado[]" onclick='contarChecks()' value="{{$u->id}}"></th>
                        
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
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{$tituloMD}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {{-- Campos --}}
                <div class="modal-body">

                    {{-- Id --}}
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="id_vtn" value="{{$idVtn}}">

                    {{-- Titulo y filtro --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='titulo')}}</label>
                            <input type="text" class="form-control" name="{{$n}}" maxlength="75" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='filtro')}}</label>
                            <select name="filtro" class="form-control">
                                <option value="" selected disabled>{{__('textos.placesholder.select')}}</option>
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
                    <div class="subtitulo-form-2">{{__('textos.subtitulos.compra_detal')}}</div>
                    <div class="fila-form">
                        {{-- Pedido mínimo --}}
                        <div>
                            <label>{{__('textos.campos.pedido_min')}}</label>
                            <input class="form-control" name="pedido_min_detal" maxlength="10" onkeypress="soloNumeros(event)" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.precio')}}</label>
                            <input class="form-control" name="precio_detal" maxlength="10" onkeypress="soloNumeros(event)" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='oferta')}}</label>
                            <input class="form-control" name="{{$n}}" maxlength="10" onkeypress="soloNumeros(event)">
                        </div>
                    </div>

                    {{-- Compra al mayor --}}
                    <div class="subtitulo-form-2">{{__('textos.subtitulos.compra_mayor')}}</div>
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.pedido_min')}}</label>
                            <input class="form-control" name="pedido_min_mayor" maxlength="10" onkeypress="soloNumeros(event)">
                        </div>
                        <div>
                            <label>{{__('textos.campos.precio')}}</label>
                            <input class="form-control" name="precio_mayor" maxlength="10" onkeypress="soloNumeros(event)">
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
                            <i class="position-absolute fas fa-image"></i>
                            <input type="file" id="inputImg" name="img" class="d-none" accept="image/jpg,image/jpeg,image/png" onchange="vistaPrevia()">
                            <img src="" class="position-relative d-none">
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
                vistaPrevia('/img/' + registroA.id + '/0');
            }

            // Vaciar
            else {
                img.removeAttribute('src');
                img.classList.add('d-none');
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