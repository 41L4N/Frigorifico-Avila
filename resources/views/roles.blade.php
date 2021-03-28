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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vtnGuardar">{{__('textos.botones.agregar')}}</button>
                <button type="button" class="btn btn-danger btn-admin" data-toggle="modal" data-target="#vtnConfirmacion" disabled>{{__('textos.botones.eliminar')}}</button>
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
                    <th>{{__('textos.formularios.etiquetas.titulo')}}</th>
                    <th>{{__('textos.formularios.etiquetas.permisos')}}</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($roles as $r)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="resultado[]" onclick='contarChecks()' value="{{$r->id}}"></th>
                        <td>{{$r->titulo}}</td>
                        <td>
                            @foreach (json_decode($r->permisos) as $p)
                                {{__('textos.rutas.'.$p)}} <br>
                            @endforeach
                        </td>
                        <td><a class="fas fa-edit" href="" onclick="event.preventDefault(); registroActual({{$r->id}})"></a></td>
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

                    {{-- Id --}}
                    <input type="hidden" name="id">

                    {{-- Titulo --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.formularios.etiquetas.'.$n = 'titulo')}}</label>
                            <input type="text" class="form-control @error($n) is-invalid @enderror" name="{{$n}}" maxlength="75" required>
                        </div>
                    </div>

                    {{-- Permisos --}}
                    <div>
                        <label>{{__('textos.formularios.etiquetas.permisos')}}</label>
                        @foreach (['roles','usuarios','inventario','ordenes-compras','ofertas','combos'] as $ruta)
                            <label>
                                <input type="checkbox" name="permisos[]" value="{{$ruta}}">
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
    {{-- Confirmación --}}
    @include('plantillas.ventana-confirmacion')
@endsection

{{-- JavaScript --}}
@section('js')
    <script src="{{asset('/js/formularios.js')}}"></script>
    <script>

        // Formulario
        function registroActual(id=null) {

            // Elemento actual
            if (id) {

                // Index
                var registroActual = datos.filter(function(x) {
                    return x.id == id;
                })[0];
    
                // Campos directos
                Object.keys(registroActual).forEach(clave => {
                    if ( campo = document.querySelector('[name=' + clave + ']') ) {
                        campo.value = registroActual[clave];
                    }
                });
    
                // Permisos
                JSON.parse(registroActual['permisos']).forEach(p => {
                    if ( campo = document.querySelector('[value=' + p + ']') ) {
                        campo.checked = true;
                    }
                });
            }

            // Ventana
            $('#vtnGuardar').modal('show');
        }

        // Datos
        var datos = @json($roles);
        var id = @json( Session::get('id') );

        // Ventana automatica si hay errores
        if (document.querySelector('#errores')) {
            registroActual();
        }
    </script>
@endsection