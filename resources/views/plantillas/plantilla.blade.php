<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        {{-- Matadatos --}}
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content\n="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{csrf_token()}}">
        {{-- Cache --}}
        <meta http-equiv="expires" content="86400">
        {{-- Motores de busqueda de Google --}}
        <meta itemprop="name" content="{{(isset($tituloMD)) ? $tituloMD : $tituloMD=config("app.name")}}">
        <meta itemprop="description" content="{{(isset($descripcionMD)) ? $descripcionMD : $descripcionMD = "" }}">
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

        {{-- Identificación --}}
        <title>{{$tituloMD}}</title>
        <link rel="shortcut icon" href="{{asset("/imgs/plantilla/icono.png")}}">
        <meta name="description" content="">
        <meta name="author" content="{{config('app.name')}}">
        <meta name="copyright" content="{{config('app.name')}}">
        <meta name="keywords" content="{{$descripcionMD}}">

        <meta name="google-site-verification" content="7-6aQ-DlXE2TjolObjA9gCIRArLi5fJ85F2PvDlMdAY" />
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-745FLYKBYH"></script>
        <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-745FLYKBYH');</script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-TKWKCVH');</script>
        
        {{-- Pixel de facebook --}}
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init', '282322586771934');fbq('track', 'PageView');</script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=282322586771934&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
        <meta name="facebook-domain-verification" content="jvplf5oa48zys36lmjlel4slsjbr44" />

        <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/e8f740b16bc50f2736050c7d2/8627172864d3acd13cea519e8.js");</script>

        {{-- Iconos --}}
        <link rel="stylesheet" href="{{asset("/iconos/css/all.min.css")}}">

        {{-- Estilos --}}
        <link rel="stylesheet" href="{{asset("/css/normalize.css")}}">
        <link rel="stylesheet" href="{{asset("/css/bootstrap/bootstrap.min.css")}}">
        <link rel="stylesheet" href="{{asset("/css/plantilla.css")}}">
        <link rel="stylesheet" href="{{asset("/css/uso-general.css")}}">
        <link rel="stylesheet" href="{{asset('/css/formularios.css')}}">
        @yield('estilos')

        {{-- JavaScript --}}
        <script src="{{asset("/js/jquery.j")}}s"></script>
        <script src="{{asset("/js/bootstrap/bootstrap.min.js")}}"></script>
    </head>
    <body>

        {{-- Contenedor principal --}}
        <div class="d-flex flex-column min-vh-100">

            {{-- Menú superior --}}
            <div class="barra-s">

                {{-- Anuncio --}}
                <div class="anuncio-barra-s">
                    <div class="container">
                        {{__('textos.parrafos.envio_gratis')}}
                        <br>
                        {{__('textos.parrafos.disfruta_precios_mayoristaistas')}}
                    </div>
                </div>

                {{-- Menú superior --}}
                <div class="container">
                    <div class="secciones-menu-s">

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
                            <div class="lista-menu-s">
                                {{-- Titulo --}}
                                <div class="opcion-menu-s">
                                    <a href="{{route('productos')}}" class="opcion-menu-s">{{__('textos.rutas.productos')}}</a>
                                </div>
                                {{-- Opciones --}}
                                <div class="opciones-lista-menu-s">
                                    @foreach (App\Models\FiltroProducto::lista() as $f)
                                        <a href="{{route('productos', ['filtros', $f->alias(), $f->id])}}" class="opcion-menu-s">{{$f->titulo}}</a>
                                    @endforeach
                                </div>
                            </div>
                            <a href="{{route('productos', 'ofertas')}}" class="opcion-menu-s">{{__('textos.rutas.ofertas')}}</a>
                            <a href="{{route('combos')}}" class="opcion-menu-s">{{__('textos.rutas.combos')}}</a>
                            <a href="{{route('contacto')}}" class="opcion-menu-s">{{__('textos.rutas.contacto')}}</a>
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
                                        <a class="opcion-menu-s" href="{{route('usuario.perfil')}}">{{__('textos.rutas.perfil')}}</a>
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
            </div>

            {{-- Alertas --}}
            @if ($a = Session::get('alerta'))
                <div class="cont-alerta">
                    <div class="d-flex align-items-center alert alert-{{$a['tipo']}} alerta" onclick='this.parentNode.removeChild(this)'>
                        <i class="{{iconos($a['tipo'])}}"></i>
                        <div>{{ ( isset( $a['texto'] ) ) ? $a['texto'] : __('textos.alertas.' . $a['tipo']) }}</div>
                    </div>
                </div>
            @endif

            {{-- Contenido de inicio --}}
            @if (Route::currentRouteName() == 'inicio')

                {{-- Carrusel --}}
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($isCarrusel as $i)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index}}" @if ($loop->first) class="active" @endif></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach ($isCarrusel as $i)
                            <div class="carousel-item @if($loop->first) active @endif">
                                <img class="d-block w-100" src="{{route('mostrar-img', ['carrusel', $i])}}" alt="{{config('app.name')}}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                {{-- Cuadros --}}
                <div class="cont-cuadros">
                    <div class="container cont-mins">
                        @foreach (['ordenes-compras', 'pagos_linea', 'envios'] as $item)
                            <div class="cuadro">
                                <i class="{{iconos($item)}}"></i>
                                <br>
                                <h4>{{__('textos.titulos.' . $item)}}</h4>
                            </div>
                        @endforeach
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

                {{-- Precios mayoristas --}}
                <div>{{__('textos.parrafos.disfruta_precios_mayoristaistas')}}</div>

                {{-- Secciones --}}
                <div class="secciones-pie-pagina">

                    {{-- Información --}}
                    <div>
                        <h5>Dirección</h5>
                        Castro Barros 1684, boedo, CABA
                    </div>

                    {{-- Envíos a domicilio --}}
                    <div>
                        <h5>Envíos a domicilio</h5>
                        CABA: {{formatos('n', 200, true)}}
                        <br>
                        Provincia: {{formatos('n', 400, true)}}
                    </div>

                    {{-- Empresa --}}
                    <div>
                        <h5>Contactanos</h5>
                        info@frigorificoavila.com
                        <br>
                        <a href="https://wa.me/541173662160" target="_blank">+54 117 3662160</a>
                    </div>

                    {{-- Redes sociales --}}
                    <div>
                        <h5>Nuestras redes sociales</h5>
                        <a href="https://www.instagram.com/frigorifico_avila/?hl=es-la" class="{{iconos('instagram')}}" target="_blank" rel="noopener"></a>
                        <a href="https://www.facebook.com/Avilafrigorifico/" class="{{iconos('facebook')}}" target="_blank" rel="noopener"></a>
                        <a href="https://twitter.com/Avilafrigor" class="{{iconos('twitter')}}" target="_blank" rel="noopener"></a>
                    </div>
                </div>

                {{-- Derechos de autor --}}
                {!! __('textos.parrafos.derechos_autor') !!}
                <br>
                {{-- Desarrollador --}}
                {!! __('textos.parrafos.desarrollador') !!}
            </div>
        </div>

        {{-- Lista de compras --}}
        {{-- Ejemplo --}}
        <div id="ejemploProductoListaCompras" class="d-none producto-lista-productos">
            {{-- Acción --}}
            <input type="hidden" name="accion" value="1">
            {{-- Tipo --}}
            <input type="hidden" name="tipo">
            {{-- Id --}}
            <input type="hidden" name="id">
            <b class="numerador"></b>
            {{-- Miniatura de imagen --}}
            <a href="" class="cont-min-img">
                <img src="" alt="{{config('app.name')}}">
            </a>
            {{-- Información --}}
            <div class="w-100">
                {{-- Titulo --}}
                <a href="" class="titulo"></a> (<span class="precio-unitario"></span>)
                {{-- Cantidad --}}
                <input type="number" name="cantidad" class="form-control w-25" min="1" max="999" onkeypress="soloNumeros(event, true)" onchange="actualizarListaCompras(this)" required>
                <b>{{__('textos.campos.subtotal')}}</b>: <span class="subtotal"></span>
            </div>
            <label class="btn btn-danger fas fa-times">
                <input type="checkbox" class="d-none" value="2" onchange="this.name='accion'; actualizarListaCompras(this);">
            </label>
        </div>
        @if (Route::currentRouteName() != "usuario.orden-compra")
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

                            {{-- Alerta --}}
                            <div class="alert alert-success text-center" id="alertaListaCompras"></div>

                            {{-- Lista --}}
                            <div id="contListaCompras"></div>
                        </div>
                        <div class="modal-footer">

                            {{-- Total --}}
                            @auth
                                <a href="{{route('usuario.orden-compra')}}" class="modal-footer flex-column justify-content-center text-center btn btn-primary w-100">
                                    {{__('textos.botones.confirmar')}}
                                    <b class="precio-total"></b>
                                </a>
                            @else
                                <div class="text-center w-100">
                                    {!! __('textos.parrafos.necesita_ingreso') !!}
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Botones flotantes --}}
        {{-- Whatsapp --}}
        <a href="https://wa.me/541173662160" target="_blank" class="fab fa-whatsapp-square btn-whatsapp"></a>

        {{-- Ventanas modales --}}
        {{-- Buscador --}}
        <div class="modal fade" id="vtnBuscador" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="GET" action="{{route('productos', ['buscar'])}}" class="modal-content">
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
        <script> var listaCompras = @json( listaCompras()['lista'] ); </script>
        <script src="{{asset('/js/plantilla.js')}}"></script>
        <script src="{{asset('/js/formularios.js')}}"></script>
        @yield('js')
    </body>
</html>