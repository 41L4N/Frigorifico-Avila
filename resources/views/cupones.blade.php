{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . prefijo('_'));
@endphp

{{-- Contenido --}}
@section('contenido')

    <form action="{{route(prefijo() . '-eliminar')}}" method="POST" class="form-resultados">
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
        @if (($registrosP = $cupones)->count())

            {{-- Tabla de resultados --}}
            <table class="tb-resultados">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(),contarChecks()'></th>
                    <th>{{__('textos.campos.titulo')}}</th>
                    <th>{{__('textos.campos.codigo')}}</th>
                    <th>{{__('textos.campos.oferta')}}</th>
                    <th>{{__('textos.campos.fecha_vencimiento')}}</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros principales --}}
                @foreach ($registrosP as $regP)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="resultados[]" onclick='contarChecks()' value="{{$regP->id}}"></th>
                        <td>{{$regP->titulo}}</td>
                        <td>{{$regP->codigo}}</td>
                        <td>{{$regP->oferta}}</td>
                        <td>{{$regP->fecha_vencimiento}}</td>
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
            <form class="modal-content" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{$tituloMD}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    {{-- Ids --}}
                    <input type="hidden" name="{{$idVtn}}">
                    <input name="id" class="d-none">

                    {{-- Titulo --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n = 'titulo')}}</label>
                            <input type="text" class="form-control" name="{{$n}}" maxlength="75" required>
                        </div>
                    </div>
                    {{-- Oferta y fecha de vencimiento --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n = 'oferta')}}</label>
                            <input type="number" class="form-control" name="{{$n}}" min="1" max="100" onkeypress="soloNumeros(event)" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n = 'fecha_vencimiento')}}</label>
                            <input type="date" class="form-control" name="{{$n}}" min="{{today()->format('Y-m-d')}}" required>
                        </div>
                    </div>

                    {{-- Productos --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n = 'productos')}}</label>
                            <div>
                                <label>
                                    <input type="radio" name="productos" onchange="contProductos.classList.toggle('visible'); contProductos.disabled = !contProductos.disabled" checked>
                                    {{__('textos.campos.todos')}}
                                </label>
                                <label>
                                    <input type="radio" name="productos" onchange="contProductos.classList.toggle('visible'); contProductos.disabled = !contProductos.disabled">
                                    {{__('textos.campos.elegir')}}
                                </label>
                                <fieldset id="contProductos" class="contenido-comprimido" disabled>
                                    <div class="fila-form">
                                        <div>
                                            <label>{{__('textos.campos.' . $n='opciones')}}</label>
                                            <input class="form-control" id="nuevaOpcion" maxlength="50">
                                        </div>
                                        <div class="w-auto">
                                            <label></label>
                                            <button type="button" class="btn btn-success fas fa-plus" onclick="agregarOpcion()"></button>
                                        </div>
                                    </div>
                                    <div id="contOpciones"></div>
                                </fieldset>
                            </div>
                        </div>
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
        var registrosP      = @json($registrosP),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );

        // Campos adicionales
        function camposAdicionales(llenar, contFormulario) {

            // Llenar
            if (llenar) {
                
            }

            // Vaciar
            else {
                
            }
        }
    </script>
@endsection