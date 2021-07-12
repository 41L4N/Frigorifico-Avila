@extends('correos.plantilla')
@section('contenido')
    <h3>Mensaje de contacto</h3>
    <br>
    <b>Nombre: </b> {{ $datos->nombre }} <br>
    <b>Apellido: </b> {{ $datos->apellido }} <br>
    <b>Email: </b> {{ $datos->email }} <br>
    <b>Teléfono: </b> {{ $datos->telf }} <br>
    <b>Mensaje: </b> {{ $datos->mensaje }} <br>
@endsection