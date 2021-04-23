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
            <td style="text-align: center; padding: 12.5px;">
                <a href="{{route("inicio")}}">
                    <img src="{{asset("/imgs/plantilla/logotipo-web.png")}}" style="width: 100%; max-width: 250px;" alt="{{config("app.name")}}">
                </a>
            </td>
        </tr>
        <tr>
            <td style="font-size: 17.5px; padding: 12.5px;">
                @yield('contenido')
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 12.5px;">
                <h2 style="margin-bottom:25px;"><a href="{{config("app.url")}}">{{config("app.name")}}</a></h2>
                {{-- @foreach ([
                    config("app.url")                                           => "l",
                    "https://www.facebook.com/kcrealtorgroup/"                  => "f",
                    "https://twitter.com/kcrealtorgroup"                        => "t",
                    "https://www.youtube.com/channel/UCnkpGRBUoQHICMwy_66rGow"  => "y",
                    "https://www.instagram.com/kcrealtorgroup/?hl=en"           => "i"
                ] as $ruta => $img)
                    <a href="{{$ruta}}" rel="noopener" target="_blank" class="text-decoration:none; margin: 0px 12.5px">
                        <img style="width: 50px" src="https://www.kcrealtorgroup.com/imgs/iconos/redes/{{$img}}g.png">
                    </a>
                @endforeach --}}
            </td>
        </tr>
    </table>
</body>
</html>