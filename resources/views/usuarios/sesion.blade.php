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
        .form-sesion {
            width: 100%;
            max-width: 750px;
            margin: 50px 15px;
            padding: 50px;
            background: rgba(0,0,0,0.8);
            color: white;
        }
        .form-sesion h3 { margin-bottom: 50px; }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')

    <div class="d-flex justify-content-center align-items-center min-vh-100">

        {{-- Formulario --}}
        <form action="/{{$nombreRuta}}" method="POST" class="form-sesion">
            @csrf

            {{-- Titulo --}}
            <h3>{{$tituloMD}}</h3>

            @switch($nombreRuta)

                {{-- Registro --}}
                @case('registro')
                    @include('usuarios.campos-basicos',$campos=["claves"])
                @break

                {{-- Ingreso --}}
                @case('ingreso')

                    {{-- Correo --}}
                    <div class="fila-form">
                        <div>
                            <label>Correo</label>
                            <input type="email" class="form-control" name="correo" autofocus required>
                        </div>
                    </div>

                    {{-- Clave --}}
                    <div class="fila-form">
                        <div>
                            <label>Clave</label>
                            <input type="password" class="form-control" name="clave" minlength="8" maxlength="15" required>
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
                            <input type="email" class="form-control" name="correo" autofocus required>
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
                            <input type="password" class="form-control" name="clave" minlength="8" maxlength="15" required>
                        </div>
                        <div>
                            <label>Repetir clave</label>
                            <input type="password" class="form-control" name="clave2" minlength="8" maxlength="15" required>
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
                    <input type="email" name="correo" class="form-control" maxlength="100" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
@endsection