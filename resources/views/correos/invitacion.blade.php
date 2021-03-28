@extends('correos.plantilla')
@section('contenido')
    <h3>¡Bienvenido a {{config("app.name")}}</h3>
    <p></p>
    <a href="{{$ruta}}">Aceptar invitación</a>
@endsection