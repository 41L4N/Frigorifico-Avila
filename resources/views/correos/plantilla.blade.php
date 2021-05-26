<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$asunto}}</title>
</head>
<body>
    <table style="width: 100%; max-width: 750px; margin: 0px auto; text-align: center;">
        <tr>
            <td style="text-align: center; padding: 7.5px;">
                <a href="{{route("inicio")}}" style="display: block;">
                    <img src="{{asset("/imgs/plantilla/logotipo-web.png")}}" style="width: 250px;" alt="{{config("app.name")}}">
                </a>
            </td>
        </tr>
        <tr>
            <td style="padding: 7.5px;">
                @yield('contenido')
            </td>
        </tr>
    </table>
</body>
</html>