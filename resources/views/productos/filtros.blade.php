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
        /* Contenedor */
        #contImgs {
            min-height: 250px;
            color: gray;
            box-shadow: 0px 0px 2.5px var(--c-plantilla);
        }
        /* Vistas previas */
        .vp-img {
            width: 250px;
            height: 250px;
            border: solid var(--c-plantilla) 1px;
            margin: .5rem;
            cursor: grab;
        }
        .vp-img img {
            max-width: 100%;
            max-height: 100%;
        }
        .vp-img .btn { top: 0px; }
        .vp-img .btn-danger { left: 0px; }
        .vp-img .btn-primary { right: 0px !important; }
        /* Barra de carga */
        .vp-img .barra-carga { background: var(--c-2); color: var(--c-letra); }
        /* Error al cargar */
        .vp-img-error { border: solid red 1px !important; }
        .vp-img-error img { filter: grayscale(100%); }
        .vp-img-error .msj-error { display: initial !important; }
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
        @if ($filtros->count())

            {{-- Tabla de resultados --}}
            <table class="tb-resultados">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(), contarChecks()'></th>
                    <th>{{__('textos.campos.titulo')}}</th>
                    <th>{{__('textos.campos.opciones')}}</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($filtros as $registro)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="resultado[]" onclick='contarChecks()' value="{{$registro->id}}"></th>
                        <td>{{$registro->titulo}}</td>
                        <td>
                            @forelse (($registro->opciones) ? $registro->opciones : [] as $subregistro)
                                {{$subregistro->titulo}}<br>
                            @empty
                                -
                            @endforelse
                        </td>
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
            <form class="modal-content" action="" method="POST">
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

                    {{-- Titulo --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='titulo')}}</label>
                            <input class="form-control" name="{{$n}}" maxlength="75" required>
                        </div>
                    </div>

                    {{-- Opciones --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='opciones')}}</label>
                            <input class="form-control" id="nuevaOpcion" maxlength="75">
                        </div>
                        <div class="w-auto">
                            <label></label>
                            <button type="button" class="btn btn-success fas fa-plus" onclick="agregarOpcion()"></button>
                        </div>
                    </div>
                    <div id="contOpciones"></div>
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

    {{-- Ejemplo de opcion --}}
    <div class="d-none fila-form" id="ejemploOpcion">
        <input type="text" class="form-control">
        <button type="button" class="btn btn-danger w-auto fas fa-times" onclick="this.parentNode.parentNode.removeChild(this.parentNode)"></button>
    </div>
@endsection

{{-- JavaScript --}}
@section('js')
    <script>

        var registros       = @json($filtros),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );

        // Campos adicionales
        function camposAdicionales(llenar, contFormulario) {

            // Llenar
            if (llenar) {

                // Opciones
                Object.values( registroA.opciones ).forEach(opcion => {
                    agregarOpcion(opcion.id,opcion.titulo);
                });
            }

            // Vaciar
            else {
                contFormulario.querySelectorAll('#contOpciones > *').forEach(opcion => {
                    opcion.parentNode.removeChild(opcion);
                });
            }
        }

        // Agregar opcion
        function agregarOpcion(idOpcion=null,valorOpcion=null) {

            // Validacion
            if (!idOpcion && !valorOpcion) {
                nuevaOpcion.required = true;
                if (!nuevaOpcion.reportValidity()) {
                    nuevaOpcion.required = false;
                    return;
                }
                nuevaOpcion.required = false;
            }

            // Opcion
            opcion = ejemploOpcion.cloneNode(true);
            opcion.classList.remove('d-none');
            opcion.removeAttribute('id');
            opcion.querySelector('input').name = 'opcion[' + ((idOpcion) ? idOpcion : '') + ']';
            opcion.querySelector('input').value = (valorOpcion) ? valorOpcion : nuevaOpcion.value;
            contOpciones.insertAdjacentElement('beforeend', opcion);
            nuevaOpcion.value = null;
        }
    </script>
    <script src="{{asset('/js/formularios.js')}}"></script>
@endsection