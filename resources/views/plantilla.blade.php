<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Matadatos --}}
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content\n="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{csrf_token()}}">
        {{-- HTML --}}
        <title>{{(isset($tituloMD)) ? $tituloMD : $tituloMD=config("app.name")}}</title>
        <meta name="description" content="{{(isset($descripcionMD)) ? $descripcionMD : $descripcionMD = "" }}">
        {{-- Motores de busqueda de Google --}}
        <meta itemprop="name" content="{{$tituloMD}}">
        <meta itemprop="description" content="{{$descripcionMD}}">
        <meta itemprop="image" content="{{ (isset($imgMD)) ? $imgMD : $imgMD = asset("imgs/plantilla/logotipo-metadatos.png")}}">
        {{-- Facebook --}}
        <meta property="og:site_name" content={{$tituloMD}}>
        <meta property="og:url" content="{{config("app.url")}}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{$tituloMD}}">
        <meta property="og:description" content="{{$descripcionMD}}">
        <meta property="og:image" content="{{$imgMD}}">
        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{$tituloMD}}">
        <meta name="twitter:description" content="{{$descripcionMD}}">
        <meta name="twitter:image" content="{{$imgMD}}">

        {{-- Ícono de pestaña --}}
        <link rel="shortcut icon" href="{{asset("/imgs/plantilla/icono.png")}}">

        {{-- Iconos --}}
        <link rel="stylesheet" href="{{asset("/iconos/css/all.min.css")}}">

        {{-- Estilos --}}
        <link rel="stylesheet" href="{{asset("/css/normalize.css")}}">
        <link rel="stylesheet" href="{{asset("/css/bootstrap/bootstrap.min.css")}}">
        <link rel="stylesheet" href="{{asset("/css/plantilla.css")}}">
        @yield('estilos')

        {{-- jQuery --}}
        <script src="{{asset("/js/jquery.j")}}s"></script>

        {{-- JavaScript --}}
        <script src="{{asset("/js/bootstrap/bootstrap.min.js")}}"></script>
    </head>
    <body>

        {{-- Contenedor principal --}}
        <div class="d-flex flex-column min-vh-100">

            {{-- Menú superior --}}
            <div class="menu-s">
                <div class="container">
                    Menú superior
                </div>
            </div>

            {{-- Contenido --}}
            <div class="container contenido d-flex justify-content-center flex-fill">

                {{-- Alertas --}}
                @if ($a = Session::get('alerta'))
                    <div class="d-flex align-items-center alert alert-{{$a['tipo']}} alerta" onclick='this.parentNode.removeChild(this)'>
                        <i class="{{iconos($a['tipo'])}}"></i>
                        <div>{{__('textos.formularios.respuestas.'.$a['msj'])}}</div>
                    </div>
                @endif

                {{-- Contenido --}}
                @yield('contenido')
            </div>
        </div>

        {{-- Pie de página --}}
        <div class="pie-pagina">
            <div class="container">
                Pie de página
            </div>
        </div>

        {{-- JavaScript --}}
        <script src="{{asset('/js/plantilla.js')}}"></script>
        @yield('js')
    </body>
</html>