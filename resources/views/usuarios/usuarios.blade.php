{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.'.prefijo());
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/formularios.css')}}">
@endsection

{{-- Contenido --}}
@section('contenido')

    <form action="{{route(prefijo().'.eliminar')}}" method="POST" class="form-resultados">
        @csrf

        {{-- Submenu --}}
        <div class="submenu-resultados">
            <div>{{$tituloMD}}</div>
            <div>
                <button type="button" class="btn btn-primary" onclick="agregar()" data-toggle="modal" data-target="#vtnGuardar">{{__('textos.botones.agregar')}}</button>
                <button type="button" class="btn btn-danger btn-admin" data-toggle="modal" data-target="#vtnConfirmacion" disabled>{{__('textos.botones.eliminar')}}</button>
            </div>
        </div>

        {{-- Resultados --}}
        @if ($usuarios->count())

            {{-- Tabla de resultados --}}
            <table class="tb-resultados">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(),contarChecks()'></th>
                    <th>{{__('textos.formularios.etiquetas.nombre') ." y ". __('textos.formularios.etiquetas.apellido')}}</th>
                    <th>{{__('textos.formularios.etiquetas.email')}}</th>
                    <th>{{__('textos.formularios.etiquetas.telf')}}</th>
                    <th>{{__('textos.formularios.etiquetas.rol')}}</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($usuarios as $u)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="resultados[]" onclick='contarChecks()' value="{{$u->id}}"></th>
                        <td>{{"$u->nombre $u->apellido"}}</td>
                        <td>{{$u->email}}</td>
                        <td>{{formatos('t',$u->telf)}}</td>
                        <td>{{$u->rol}}</td>
                        <td><a class="fas fa-edit" href="" onclick="event.preventDefault(); editar({{$loop->index}})"></a></td>
                    </tr>
                @endforeach
            </table>

        {{-- Sin resultados --}}
        @else
            <div class="sin-resultados">
                <i class="fas fa-folder-open"></i>
                <div>{{__('textos.contenido.sin-resultados')}}</div>
            </div>
        @endif
    </form>

    {{-- Ventanas modales --}}
    {{-- Agregar --}}
    <div class="modal fade" id="vtnGuardar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{$tituloMD}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    {{-- Errores --}}
                    @include('plantillas.errores')

                    {{-- Campos --}}
                    @include('usuarios.campos-basicos',$campos = ['id','telf'])

                    {{-- Rol --}}
                    <div>
                        <label>{{__('textos.formularios.etiquetas.rol')}}</label>
                        <select name="rol" class="form-control" required>
                            @foreach ($roles as $r)
                                <option value="" selected disabled>Elegir</option>
                                <option value="{{$r->id}}">{{$r->titulo}}</option>
                            @endforeach
                        </select>
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
    <script src="{{asset('/js/formularios.js')}}"></script>
    @if(count($errors))
        <script>
            $('#vtnGuardar').modal('show');
        </script>
    @endif
    <script>

        // Datos
        var datos = {!! json_encode($usuarios) !!};

        // Agregar
        function agregar() {
            vtnGuardar.querySelector('form').reset();
        }

        // Editar
        function editar(i) {

            // Campos directos
            Object.keys(datos[i]).forEach(clave => {
                if ( campo = document.querySelector('[name=' + clave + ']') ) {
                    campo.value = datos[i][clave];
                }
            });

            // Teléfono
            JSON.parse(datos[i]['permisos']).forEach(p => {
                if ( campo = document.querySelector('[value=' + p + ']') ) {
                    campo.checked = true;
                }
            });

            // Ventana
            $('#vtnGuardar').modal('show');
        }
    </script>
@endsection