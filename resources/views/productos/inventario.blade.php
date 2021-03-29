{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . prefijo('_'));
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/formularios.css')}}">
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
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{$tituloMD}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {{-- Campos --}}
                <div class="modal-body">
                    <input type="hidden" name="id_vtn" value="{{$idVtn}}">

                    {{-- Titulo --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='titulo')}}</label>
                            <input type="text" class="form-control" name="{{$n}}" maxlength="75" required>
                        </div>
                    </div>

                    {{-- Precio detal --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='precio_detal')}}</label>
                            <input class="form-control" name="{{$n}}" maxlength="6" onkeypress="soloNumeros(event)" required>
                        </div>
                    </div>

                    {{-- Compra mínima --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='compra_min')}}</label>
                            <input class="form-control" name="{{$n}}" maxlength="3" onkeypress="soloNumeros(event)">
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='precio_detal')}}</label>
                            <input class="form-control" name="{{$n}}" maxlength="6" onkeypress="soloNumeros(event)">
                        </div>
                    </div>

                    {{-- Fotos --}}
                    

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

        var registros       = @json($productos),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );
        if ( Object.keys(mensajesErrores).length || Object.keys(valoresErrores).length ) {
            llenarFormulario(null, (typeof valoresErrores.id_vtn === 'undefined') ? "" : '#' + valoresErrores.id_vtn);
        }

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