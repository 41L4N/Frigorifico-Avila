{{-- Plantilla --}}
@extends('plantilla')

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
    
                @switch($seccionRuta)
    
                    {{-- Registro --}}
                    @case('registro')
                        @include('usuarios.campos-basicos',$campos=["claves"])
                    @break
    
                    {{-- Ingreso --}}
                    @case('ingreso')
    
                        {{-- Email --}}
                        <div class="fila-form">
                            <div>
                                <label>{{__('textos.formularios.etiquetas.email')}}</label>
                                <input type="email" class="form-control" name="email" autofocus required>
                            </div>
                        </div>
    
                        {{-- Clave --}}
                        <div class="fila-form">
                            <div>
                                <label>{{__('textos.formularios.etiquetas.clave')}}</label>
                                <input type="password" class="form-control" name="password" minlength="8" maxlength="15" required>
                            </div>
                        </div>
    
                        {{-- Enlace --}}
                        <div class="fila-form">
                            <a href="" data-toggle="modal" data-target="#vtnRecuperar">{{__('textos.formularios.enlaces.recuperar_clave')}}</a>
                        </div>
                    @break
    
                    {{-- Recuperar --}}
                    @case("recuperacion-clave")
    
                        {{-- Email --}}
                        <div class="fila-form">
                            <div>
                                <label>{{__('textos.formularios.etiquetas.email')}}</label>
                                <input type="email" class="form-control" name="email" autofocus required>
                            </div>
                        </div>
                    @break
    
                    {{-- Renovar clave --}}
                    @case("renovacion-clave")
    
                        {{-- Clave y validacion --}}
                        {{-- <input type="hidden" value="{{Route::current()->parameters('codigo')["codigo"]}}" name="codigo"> --}}
                        <div class="fila-form">
                            <div>
                                <label>{{__('textos.formularios.etiquetas.clave')}}</label>
                                <input type="password" class="form-control" name="password" minlength="8" maxlength="15" required>
                            </div>
                            <div>
                                <label>{{__('textos.formularios.etiquetas.confirmar_clave')}}</label>
                                <input type="password" class="form-control" name="password2" minlength="8" maxlength="15" required>
                            </div>
                        </div>
                    @break
                @endswitch

                {{-- Botones --}}
                <div class="btns-form">
                    <button type="submit" class="btn btn-primary">{{__('textos.formularios.botones.enviar')}}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Ventana modal para recuperar clave --}}
    <div class="modal fade" id="vtnRecuperar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Recuperar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    Email
                    <input type="email" name="email" class="form-control" maxlength="100" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
@endsection