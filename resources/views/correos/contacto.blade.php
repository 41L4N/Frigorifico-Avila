@extends('correos.plantilla')
@section('contenido')
    <p>
        Saludos,
        <br><br>
        Le escribe {{"$datos->nombre $datos->apellido"}}
        <br><br>
        Correo: {{$datos->correo}}
        <br><br>
        Telefono: {{$datos->telf}}
        <br><br>
        {{$datos->mensaje}}
    </p>
@endsection