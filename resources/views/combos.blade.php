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

        {{-- Registros --}}
        @if (($registros = $combos)->count())

            {{-- Tabla de resultados --}}
            <table class="tb-registros">

                {{-- Campos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(),contarChecks()'></th>
                    <th>{{__('textos.campos.titulo')}}</th>
                    <th>{{__('textos.campos.productos')}}</th>
                    <th>{{__('textos.campos.precio')}}</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($registros as $reg)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="registros[]" onclick='contarChecks()' value="{{$reg->id}}"></th>
                        <td>{{$reg->titulo}}</td>
                        <td>
                            @foreach ($reg->titulos_productos as $p)
                                {{$p->titulo}}
                            @endforeach
                        </td>
                        <td>{{formatos('n', $reg->precio, true)}}</td>
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
                    <input type="hidden" name="id_vtn" value="{{$idVtn}}">
                    <input name="id" class="d-none">

                    {{-- Título y precio --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='titulo')}}</label>
                            <input type="text" name="{{$n}}" class="form-control" maxlength="75" required>
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='precio')}}</label>
                            <input type="number" name="{{$n}}" class="form-control" min="{{$min=1}}" max="99999" value="{{$min}}" onkeypress="soloNumeros(event)" required>
                        </div>
                    </div>

                    {{-- Lista de productos --}}
                    <div class="subtitulo-form">{{__('textos.campos.productos')}}</div>
                    <div class="fila-form" id="camposNuevoElemento">
                        <div>
                            <label>{{__('textos.campos.producto')}}</label>
                            <select class="form-control">
                                <option value="" selected disabled>{{__('textos.placeholders.select')}}</option>
                                @foreach ($productos as $p)
                                    <option value="{{$p->id}}">{{$p->titulo}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>{{__('textos.campos.cantidad')}}</label>
                            <input type="number" class="form-control" min="{{$min=1}}" max="99999" value="{{$min}}" onkeypress="soloNumeros(event)">
                        </div>
                        <div class="w-auto">
                            <label></label>
                            <button type="button" class="btn btn-success fas fa-plus" onclick="agregarElemento()"></button>
                        </div>
                    </div>
                    <div id="contElementos"></div>
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
    <div class="d-none fila-form" id="ejemploNuevoElemento">
        <select name="productos[iElemento][id]" class="form-control">
            <option value="" selected disabled>{{__('textos.placeholders.select')}}</option>
            @foreach ($productos as $p)
                <option value="{{$p->id}}">{{$p->titulo}}</option>
            @endforeach
        </select>
        <input type="number" name="productos[iElemento][cantidad]" class="form-control" min="{{$min=1}}" max="99999" onkeypress="soloNumeros(event)">
        <button type="button" class="btn btn-danger w-auto fas fa-times" onclick="this.parentNode.remove()"></button>
    </div>
@endsection

{{-- JavaScript --}}
@section('js')
    <script>
        var registrosP      = @json($registros),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );

        // Campos adicionales
        function camposAdicionales(llenar, contFormulario) {

            // Llenar
            if (llenar) {
                if (elementos = JSON.parse(registroA.productos)) {
                    elementos.forEach(element => {
                        agregarElemento(element)
                    });
                }
            }

            // Vaciar
            else {
                contElementos.innerHTML = ''
            }
        }

        // Agregar producto
        var camposNuevoElemento = document.querySelector('#camposNuevoElemento').innerHTML;
        var iElemento = 0;
        function agregarElemento(datos=null) {

            var campos = 'input, select'
            var datosNuevoElemento = document.querySelector('#camposNuevoElemento').querySelectorAll(campos)

            // Validación
            if (!datos) {
                var validacion = true;
                datosNuevoElemento.forEach(campo => {
                    campo.required = true;
                    if (!campo.reportValidity()) {
                        validacion = false;
                    }
                    campo.required = false;
                });
                if (!validacion) {
                    return;
                }
            }

            // Datos
            if (datos) {
                Object.keys(datos).forEach((clave,iDato) => {
                    datosNuevoElemento[iDato].value = datos[clave]
                });
            }

            // Nuevo elemento
            nuevoElemento = ejemploNuevoElemento.cloneNode(true)
            nuevoElemento.removeAttribute('id')
            nuevoElemento.querySelectorAll(campos).forEach((campo, iCampo) => {
                campo.value = datosNuevoElemento[iCampo].value
                campo.name = campo.name.replace('iElemento', iElemento)
            });
            iElemento++
            nuevoElemento.classList.remove('d-none')
            contElementos.insertAdjacentElement('beforeend', nuevoElemento)
            document.querySelector('#camposNuevoElemento').innerHTML = camposNuevoElemento
        }
    </script>
@endsection