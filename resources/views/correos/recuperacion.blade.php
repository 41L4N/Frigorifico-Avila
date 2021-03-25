@extends('correos.plantilla')
@section('contenido')
    <h3>¡Recuperar contraseña!</h3>
    <p>Se ha registrado en nuestra base de datos una nueva solicitud para recuperar su contraseña, haz click en el siguiente enlace para continuar con la solicitud.</p>
    <a href="{{$ruta}}">Restablecer contraseña</a>
@endsection