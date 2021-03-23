{{-- Plantilla --}}
@extends('plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = str_replace("-", " ", ucfirst( $nombreRuta = Request::route('seccion') ) );
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

            <form action="/{{$nombreRuta}}" method="POST" class="w-100">
                @csrf
    
                {{-- Titulo --}}
                <div class="titulo-form">{{$tituloMD}}</div>
    
                @switch($nombreRuta)
    
                    {{-- Registro --}}
                    @case('registro')
                        @include('usuarios.campos-basicos',$campos=["claves"])
                    @break
    
                    {{-- Ingresar --}}
                    @case('ingresar')
    
                        {{-- Correo --}}
                        <div class="fila-form">
                            <div>
                                <label>Correo</label>
                                <input type="email" class="form-control" name="email" autofocus required>
                            </div>
                        </div>
    
                        {{-- Clave --}}
                        <div class="fila-form">
                            <div>
                                <label>Clave</label>
                                <input type="password" class="form-control" name="password" minlength="8" maxlength="15" required>
                            </div>
                        </div>
    
                        {{-- Enlace --}}
                        <div class="fila-form">
                            <div>
                                <a href="" data-toggle="modal" data-target="#vtnRecuperar">Recuperar clave</a>
                            </div>
                        </div>
                    @break
    
                    {{-- Recuperar --}}
                    @case("recuperar-clave")
    
                        {{-- Correo --}}
                        <div class="fila-form">
                            <div>
                                <label>Correo</label>
                                <input type="email" class="form-control" name="email" autofocus required>
                            </div>
                        </div>
                    @break
    
                    {{-- Renovar clave --}}
                    @case("renovar-clave")
    
                        {{-- Clave y validacion --}}
                        {{-- <input type="hidden" value="{{Route::current()->parameters('codigo')["codigo"]}}" name="codigo"> --}}
                        <div class="fila-form">
                            <div>
                                <label>Clave</label>
                                <input type="password" class="form-control" name="password" minlength="8" maxlength="15" required>
                            </div>
                            <div>
                                <label>Repetir clave</label>
                                <input type="password" class="form-control" name="password2" minlength="8" maxlength="15" required>
                            </div>
                        </div>
                    @break
                @endswitch

                {{-- Botones --}}
                <div class="btns-form">
                    <button type="submit" class="btn btn-primary">Enviar</button>
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