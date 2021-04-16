{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . str_replace('-', '_', $nRuta = Route::currentRouteName()) );
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
        @if ($usuarios->count())

            {{-- Tabla de resultados --}}
            <table class="tb-registros">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(),contarChecks()'></th>
                    <th>{{__('textos.campos.nombre_apellido')}}</th>
                    <th>{{__('textos.campos.email')}}</th>
                    {{-- <th>{{__('textos.campos.telf')}}</th> --}}
                    <th>{{__('textos.campos.rol')}}</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($usuarios as $u)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="registros[]" onclick='contarChecks()' value="{{$u->id}}"></th>
                        <td>{{"$u->nombre $u->apellido"}}</td>
                        <td>{{$u->email}}</td>
                        {{-- <td>{{ ($u->telf) ? formatos('t', $u->telf, true) : "-" }}</td> --}}
                        <td>{{$u->rolP()}}</td>
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
                {{-- Campos --}}
                <div class="modal-body">
                    {{-- Id de ventana --}}
                    <input type="hidden" name="id_vtn" value="{{$idVtn}}">
                    @include('usuarios.campos-basicos', $campos=['id'])
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

        var registrosP      = @json($usuarios),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );

        // Campos adicionales
        function camposAdicionales(llenar, contFormulario) {

            // Llenar
            if (llenar) {

                // Teléfono
                // var telf = (typeof registroA.telf === 'string') ? JSON.parse( registroA.telf ) : registroA.telf;
                // Object.keys( telf ).forEach(clave => {
                //     if ( campo = document.querySelector(contFormulario + ' [name="telf[' + clave + ']"]') ) {
                //         campo.value = telf[clave];
                //     }
                // });
            }
        }
    </script>
@endsection