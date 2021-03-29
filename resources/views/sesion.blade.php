{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.formularios.titulos.'. $seccionRuta = Request::route('seccion'));
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/formularios.css')}}">
    <style>

        /* Imagen */
        .cont-img-sesion, .cont-form-sesion {
            width: 50%;
        }
        .cont-img-sesion img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Formulario */
        .cont-form-sesion {
            color: white;
            background: rgba(0,0,0,0.8);
            padding: 5%;
        }

        /* Responsive */
        @media only screen and (max-width: 768px) {
            .cont-img-sesion, .cont-form-sesion {
                width: 100%;
            }
        }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')

    {{-- Contenedor --}}
    <div class="d-flex flex-wrap w-100">

        {{-- Imagen --}}
        <div class="cont-img-sesion">
            <img src="{{asset('/imgs/sesion.jpg')}}" alt="{{config('app.name')}}">
        </div>

        {{-- Formulario --}}
        <div class="d-flex align-items-center justify-content-center cont-form-sesion">
            <form action="/{{$seccionRuta}}" method="POST" class="w-100">
                @csrf

                {{-- Titulo --}}
                <div class="titulo-form">{{ $tituloMD }}</div>

                {{-- Campos --}}
                @switch($seccionRuta)

                    {{-- Registro --}}
                    @case('registro')
                        @include('usuarios.campos-basicos',$campos=["contraseñas"])
                    @break

                    {{-- Ingreso --}}
                    @case('ingreso')

                        {{-- Email --}}
                        <div class="fila-form">
                            <div>
                                <label>{{__('textos.campos.' . $n='email')}}</label>
                                <input type="email" class="form-control" name="{{$n}}" maxlength="75" autofocus required>
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="fila-form">
                            <div>
                                <label>{{__('textos.campos.' . $n='contraseña')}}</label>
                                <input type="password" class="form-control" name="password" minlength="8" maxlength="15" required>
                            </div>
                        </div>

                        {{-- Enlace --}}
                        <div class="fila-form">
                            <div>
                                <a href="" data-toggle="modal" data-target="#vtnRecuperar">{{__('textos.rutas.recuperar-contraseña')}}</a>
                            </div>
                        </div>
                    @break

                    {{-- Recuperar contraseña --}}
                    @case("recuperacion-contraseña")

                        {{-- Email --}}
                        <div class="fila-form">
                            <div>
                                <label>{{__('textos.campos.' . $n='email')}}</label>
                                <input type="email" class="form-control" name="{{$n}}" autofocus required>
                            </div>
                        </div>
                    @break

                    {{-- Renovar contraseña --}}
                    @case("renovacion-contraseña")

                        {{-- Contraseña y validación --}}
                        <input type="hidden" value="{{ Request::route('codigo_acceso') }}" name="codigo_acceso">
                        <div class="fila-form">
                            <div>
                                <label>{{__('textos.campos.' . $n='contraseña')}}</label>
                                <input type="password" class="form-control" name="password" minlength="8" maxlength="15" required>
                            </div>
                            <div>
                                <label>{{__('textos.campos.' . $n='confirmar-contraseña')}}</label>
                                <input type="password" class="form-control" name="confirmacion_password" minlength="8" maxlength="15" required>
                            </div>
                        </div>
                    @break
                @endswitch

                {{-- Botones --}}
                <div class="btns-form">
                    <button type="submit" class="btn btn-primary">{{__('textos.botones.enviar')}}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Ventana modal para recuperar contraseña --}}
    <div class="modal fade" id="{{$idVtn="vtnRecuperar"}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('sesion.recuperacion-contraseña')}}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('textos.formularios.titulos.recuperar-contraseña')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_vtn" value="{{$idVtn}}">
                    {{__('textos.campos.' . $n='email')}}
                    <input type="email" name="{{$n}}" class="form-control" maxlength="75" required>
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
    <script>
        var mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );
        if ( Object.keys(mensajesErrores).length || Object.keys(valoresErrores).length ) {
            llenarFormulario(null, (typeof valoresErrores.id_vtn === 'undefined') ? "" : '#' + valoresErrores.id_vtn);
        }
    </script>
@endsection