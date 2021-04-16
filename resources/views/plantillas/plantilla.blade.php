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
        <link rel="stylesheet" href="{{asset("/css/uso-general.css")}}">
        <link rel="stylesheet" href="{{asset('/css/formularios.css')}}">
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
                <div class="container d-flex align-items-center justify-content-between contenido-menu-s">

                    {{-- Lado izquierdo --}}
                    {{-- Boton de menú responsive --}}
                    <div class="cont-icono-menu-s">
                        <i class="fas fa-bars icono-menu-s" onclick="menuR.classList.toggle('centro-menu-s-visible')"></i>
                    </div>

                    {{-- Logotipo --}}
                    <div class="d-flex align-items-center izquierda-menu-s">

                        {{-- Logotipo --}}
                        <a href="{{route("inicio")}}">
                            <img src="/imgs/plantilla/logotipo-web.png" class="logotipo-menu-s" alt="{{config("app.name")}}">
                        </a>
                    </div>

                    {{-- Lado central --}}
                    <div class="centro-menu-s" id="menuR">

                        {{-- Boton de menú responsive --}}
                        <div class="cont-icono-menu-s">
                            <i class="fas fa-times icono-menu-s" onclick="menuR.classList.toggle('centro-menu-s-visible')"></i>
                        </div>

                        {{-- Opciones --}}
                        <a href="{{route('inicio')}}" class="opcion-menu-s">{{__('textos.rutas.inicio')}}</a>
                        <a href="{{route('productos')}}" class="opcion-menu-s">{{__('textos.rutas.productos')}}</a>
                        <a href="{{route('productos', 'ofertas')}}" class="opcion-menu-s">{{__('textos.rutas.ofertas')}}</a>
                        <a href="{{route('combos')}}" class="opcion-menu-s">{{__('textos.rutas.combos')}}</a>
                        @auth
                            {{-- Lista de menú --}}
                            <div class="lista-menu-s">
                                {{-- Titulo --}}
                                <div class="opcion-menu-s">
                                    {{Auth::user()->nombre}} <i class="fas fa-caret-down"></i>
                                </div>
                                {{-- Opciones --}}
                                <div class="opciones-lista-menu-s">
                                    @if (Auth::user()->administrador)
                                        <a class="opcion-menu-s" href="{{route('administrador.panel')}}">{{__('textos.rutas.administrador.panel')}}</a>
                                    @endif
                                    <a class="opcion-menu-s" href="{{route('usuario.perfil')}}">{{__('textos.rutas.usuario')}}</a>
                                    <a class="opcion-menu-s" href="{{route('usuario.salir')}}">{{__('textos.rutas.salir')}}</a>
                                </div>
                            </div>
                        @else
                            <a href="{{route('sesion', 'ingreso')}}" class="opcion-menu-s">{{__('textos.rutas.ingreso')}}</a>
                        @endauth
                    </div>

                    {{-- Lado derecho --}}
                    {{-- Opciones de usuario --}}
                    <div class="derecha-menu-s">
                        <i class="fas fa-search opcion-menu-s icono-menu-s" data-toggle="modal" data-target="#vtnBuscador"></i>
                    </div>
                </div>
            </div>

            {{-- Alertas --}}
            @if ($a = Session::get('alerta'))
                <div class="cont-alerta">
                    <div class="d-flex align-items-center alert alert-{{$a['tipo']}} alerta" onclick='this.parentNode.removeChild(this)'>
                        <i class="{{iconos($a['tipo'])}}"></i>
                        <div>{{__('textos.alertas.'.( ( isset( $a['texto'] ) ) ? $a['texto'] : $a['tipo'] ) )}}</div>
                    </div>
                </div>
            @endif

            {{-- Contenido --}}
            <div class="container contenido d-flex flex-column flex-fill">
                @yield('contenido')
            </div>
        </div>

        {{-- Pie de página --}}
        <div class="pie-pagina">
            <div class="container">
                Pie de página
            </div>
        </div>

        {{-- Lista de compras --}}
        @if (Route::currentRouteName() != "orden-compra")
            {{-- Boton --}}
            <div class="btn-compras fas fa-shopping-cart" data-toggle="modal" data-target="#vtnListaCompras">
                <span class="n-compras"></span>
            </div>
            {{-- Ventana --}}
            <div class="modal fade" id="vtnListaCompras" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">{{__('textos.titulos.lista_compras')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">

                            {{-- Ejemplo --}}
                            <div id="ejemploProductoListaCompras" class="producto-lista-productos">
                                {{-- Acción --}}
                                <input type="hidden" name="accion" value="1">
                                {{-- Tipo --}}
                                <input type="hidden" name="tipo">
                                {{-- Id --}}
                                <input type="hidden" name="id">
                                {{-- Precio unitario --}}
                                <input type="hidden" name="precio_unitario" disabled>
                                <b class="numerador"></b>
                                {{-- Miniatura de imagen --}}
                                <a href="" class="cont-min-img">
                                    <img src="" alt="{{config('app.name')}}">
                                </a>
                                {{-- Información --}}
                                <div class="w-100">
                                    <a href="" class="titulo"></a> (<span class="precio-unitario"></span>)
                                    {{-- Cantidad --}}
                                    <input type="number" name="cantidad" class="form-control w-25" min="1" max="999" onkeypress="soloNumeros(event)" onchange="actualizarListaCompras(this)" required>
                                    <b class="subtotal"></b>
                                </div>
                                <label class="btn btn-danger fas fa-times">
                                    <input type="checkbox" class="d-none" value="2" onchange="this.name='accion'; actualizarListaCompras(this);">
                                </label>
                            </div>

                            {{-- Lista --}}
                            <div id="contListaCompras"></div>
                        </div>
                        {{-- Total --}}
                        <a href="{{route('orden-compra')}}" class="modal-footer flex-column justify-content-center text-center btn btn-primary">
                            {{__('textos.botones.confirmar')}}
                            <b class="precio-total"></b>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Botones flotantes --}}
        {{-- Whatsapp --}}

        {{-- Ventanas modales --}}
        {{-- Buscador --}}
        <div class="modal fade" id="vtnBuscador" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="GET" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buscar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                        {{-- Busqueda --}}
                        <div class="fila-form">
                            <div>
                                <input type="text" class="form-control" name="busqueda" required>
                            </div>
                        </div>

                        {{-- Filtro --}}
                        {{-- @foreach (App\FiltroArts::campos("tipo") as $url => $filtro)
                            <div class="fila-form">
                                <div>
                                    {{$filtro}}
                                    <select name="{{$url}}" class="form-control">
                                        <option value="" selected disabled>Elegir</option>
                                        @foreach (App\FiltroArts::where("tipo",$filtro)->pluck("titulo")->toArray() as $titulo)
                                            <option value="{{$titulo}}">{{$titulo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- JavaScript --}}
        <script> var listaCompras = @json( listaCompras() ); </script>
        <script src="{{asset('/js/plantilla.js')}}"></script>
        <script src="{{asset('/js/formularios.js')}}"></script>
        @yield('js')
    </body>
</html>