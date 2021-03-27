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

    <form action="" method="POST" class="form-resultados">

        {{-- Submenu --}}
        <div class="submenu-resultados">
            <div>{{$tituloMD}}</div>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vtnGuardar">{{__('textos.botones.agregar')}}</button>
                <button type="button" class="btn btn-danger">{{__('textos.botones.eliminar')}}</button>
            </div>
        </div>

        {{-- Resultados --}}
        @if ($roles->count())

            {{-- Tabla de resultados --}}
            <table class="tb-resultados">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(),contarChecks()'></th>
                </tr>

                {{-- Registros --}}
                @foreach ($roles as $r)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td><input type="checkbox" name="resultado[]" onclick='contarChecks()' value="{{$r->id}}"></td>
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
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('textos.botones.agregar')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    {{-- Errores --}}
                    @include('plantillas.errores')

                    {{-- Titulo --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.formularios.etiquetas.titulo')}}</label>
                            <input type="text" class="form-control" name="titulo" maxlength="75" required>
                        </div>
                    </div>

                    {{-- Permisos --}}
                    <div>
                        <label>{{__('textos.formularios.etiquetas.permisos')}}</label>
                        @foreach (['roles','usuarios','inventario','ordenes-compras','ofertas','combos'] as $ruta)
                            <label>
                                <input type="checkbox" name="permisos[{{$ruta}}]">
                                {{__('textos.rutas.'.$ruta)}}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('textos.botones.cancelar')}}</button>
                    <button class="btn btn-primary">{{__('textos.botones.enviar')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- JavaScript --}}
@section('js')
    <script src="{{asset('/js/formularios.js')}}"></script>
    @if(count($errors))
        <script>
            $('#vtnGuardar').modal('show');
        </script>
    @endif
@endsection