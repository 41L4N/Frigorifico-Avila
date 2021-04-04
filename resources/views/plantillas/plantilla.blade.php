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
                        
                    </div>

                    {{-- Lado derecho --}}
                    {{-- Opciones de usuario --}}
                    <div class="derecha-menu-s">
                        @auth
                            {{-- Lista de menú --}}
                            <div class="lista-menu-s">
                                {{-- Titulo --}}
                                <div class="titulo-lista-menu-s">
                                    {{Auth::user()->nombre}} <i class="fas fa-caret-down"></i>
                                </div>
                                {{-- Opciones --}}
                                <div class="opciones-lista-menu-s">
                                    @if (Auth::user()->administrador)
                                        <a class="opcion-menu-s" href="{{route('panel-administrador')}}">{{__('textos.rutas.panel_administrador')}}</a>
                                    @endif
                                    <a class="opcion-menu-s" href="{{route('usuario-perfil')}}">{{__('textos.rutas.usuario')}}</a>
                                    <a class="opcion-menu-s" href="{{route('usuario-salir')}}">{{__('textos.rutas.salir')}}</a>
                                </div>
                            </div>
                        @else
                            <a class="fas fa-user opcion-menu-s icono-menu-s" href="{{route('sesion','ingreso')}}"></a>
                        @endauth
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

            {{-- Botones flotantes --}}
            {{-- Whatsapp --}}

            {{-- Lista de compras --}}
            <div class="btn-compras fas fa-shopping-cart" data-toggle="modal" data-target="#vtnCompras">
                <span class="n-compras"></span>
            </div>

            {{-- Ventanas modales --}}
            {{-- Lista de compras --}}
            <div class="modal fade" id="vtnCompras" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">{{__('textos.titulos.lista_compra')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            @foreach ($listaCompras as $c)
                                <form action="{{route('lista-compras')}}" method="POST" class="producto-lista-compras">
                                    {{-- Acción --}}
                                    <input type="hidden" name="accion" value="1">
                                    {{-- Id de producto --}}
                                    <input type="hidden" name="id_producto" value="{{$c->id}}">
                                    {{-- Precio --}}
                                    <input type="hidden" name="precio_unitario" value="{{$c->precio_unitario}}" disabled>
                                    <b>{{$loop->iteration}}</b>
                                    {{-- Miniatura de imagen --}}
                                    <a href="{{$rutaP = route('productos', [$c->alias(), $c->id])}}" class="min-img">
                                        <img src="{{route('mostrar-img', [$c->getTable(), $c->id])}}" alt="{{config('app.name') ." " . $c->alias()}}">
                                    </a>
                                    {{-- Información --}}
                                    <div class="w-100">
                                        <a href="{{$rutaP}}">{{$c->titulo}}</a> ({{formatos('n', $c->precio_unitario, true)}})
                                        {{-- Cantidad --}}
                                        <input type="number" name="cantidad" class="form-control w-25" min="1" value="{{$c->cantidad}}" onkeypress="soloNumeros(event ,5)" onchange="listaCompras(this)">
                                        <b class="subtotal">{{formatos('n', $c->precio_unitario * $c->cantidad, true)}}</b>
                                    </div>
                                    <label class="btn btn-danger fas fa-times">
                                        <input type="checkbox" name="accion" class="d-none" value="2" onchange="listaCompras(this)">
                                    </label>
                                </form>
                            @endforeach
                        </div>
                        <a href="{{route('orden-compra')}}" class="modal-footer justify-content-center text-center btn btn-primary">
                            <div>
                                {{__('textos.botones.confirmar')}}
                                <br>
                                <b id="precioTotal"></b>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Buscador --}}
            <div class="modal fade" id="vtnBuscar" tabindex="-1" role="dialog" aria-hidden="true">
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
        </div>

        {{-- Pie de página --}}
        <div class="pie-pagina">
            <div class="container">
                Pie de página
            </div>
        </div>

        {{-- JavaScript --}}
        <script src="{{asset('/js/formularios.js')}}"></script>
        <script src="{{asset('/js/plantilla.js')}}"></script>
        @yield('js')
    </body>
</html>