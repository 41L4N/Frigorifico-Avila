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
        @if ($roles->count())

            {{-- Tabla de resultados --}}
            <table class="tb-registros">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(),contarChecks()'></th>
                    <th>{{__('textos.campos.titulo')}}</th>
                    <th>{{__('textos.campos.permisos')}}</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($roles as $r)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="registros[]" onclick='contarChecks()' value="{{$r->id}}"></th>
                        <td>{{$r->titulo}}</td>
                        <td>
                            @foreach (json_decode($r->permisos) as $p)
                                {{__('textos.rutas.' . str_replace('-', '_', $p))}}<br>
                            @endforeach
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

                    {{-- Permisos --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.permisos')}}</label>
                            <div class="lista-items-check">
                                @foreach (['roles','usuarios','productos','combos','ordenes-compras'] as $ruta)
                                    <label class="item-check">
                                        <input type="checkbox" name="permisos[]" value="{{$ruta}}" onchange="this.parentNode.classList.toggle('activa')">
                                        {{__('textos.rutas.' . str_replace('-', '_', $ruta))}}
                                    </label>
                                @endforeach
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
    {{-- Confirmaci??n --}}
    @include('plantillas.ventana-confirmacion')
@endsection

{{-- JavaScript --}}
@section('js')
    <script>
        var registrosP      = @json($roles),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );

        // Campos adicionales
        function camposAdicionales(llenar, contFormulario) {

            // Llenar
            if (llenar) {
                // Permisos
                var permisos = (typeof registroA.permisos === 'string') ? JSON.parse( registroA.permisos ) : registroA.permisos;
                permisos.forEach(p => {
                    if ( campo = document.querySelector(contFormulario + ' [value=' + p + ']') ) {
                        campo.parentNode.click();
                    }
                });
            }

            // Vaciar
            else {
                contFormulario.querySelectorAll('.activo, .activa').forEach(campo => {
                    campo.classList.remove('activo', 'activa');
                });
            }
        }
    </script>
@endsection