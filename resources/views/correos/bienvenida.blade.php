@extends('correos.plantilla')
@section('contenido')
    <h3>{{ __('textos.titulos.bienvenida_app_name') }}</h3>
    <p> {!! nl2br( __('textos.parrafos.bienvenida') ) !!}</p>
@endsection