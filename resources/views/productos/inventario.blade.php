{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . prefijo('_'));
@endphp

{{-- Estilos --}}
@section('estilos')
    <link rel="stylesheet" href="{{asset('/css/formularios.css')}}">
    <style>
        /* Contenedor */
        #contImgs {
            min-height: 250px;
            color: gray;
            box-shadow: 0px 0px 2.5px var(--c-plantilla);
        }
        /* Vistas previas */
        .vp-img {
            width: 250px;
            height: 250px;
            border: solid var(--c-plantilla) 1px;
            margin: .5rem;
            cursor: grab;
        }
        .vp-img img {
            max-width: 100%;
            max-height: 100%;
        }
        .vp-img .btn { top: 0px; }
        .vp-img .btn-danger { left: 0px; }
        .vp-img .btn-primary { right: 0px !important; }
        /* Barra de carga */
        .vp-img .barra-carga { background: var(--c-2); color: var(--c-letra); }
        /* Error al cargar */
        .vp-img-error { border: solid red 1px !important; }
        .vp-img-error img { filter: grayscale(100%); }
        .vp-img-error .msj-error { display: initial !important; }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')

    <form action="{{route(prefijo() . '.eliminar')}}" method="POST" class="form-resultados">
        @csrf

        {{-- Submenu --}}
        <div class="submenu-resultados">
            <div>{{$tituloMD}}</div>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vtnGuardar">{{__('textos.botones.agregar')}}</button>
                <button type="button" class="btn btn-danger btn-admin" data-toggle="modal" data-target="#vtnConfirmacion" disabled>{{__('textos.botones.eliminar')}}</button>
            </div>
        </div>

        {{-- Resultados --}}
        @if ($productos->count())

            {{-- Tabla de resultados --}}
            <table class="tb-resultados">

                {{-- Titulos --}}
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkPrincipal" onchange='clickTodos(), contarChecks()'></th>
                    
                    <th><i class="fas fa-cogs"></i></th>
                </tr>

                {{-- Registros --}}
                @foreach ($productos as $u)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <th><input type="checkbox" name="resultado[]" onclick='contarChecks()' value="{{$u->id}}"></th>
                        
                        <td><a class="fas fa-edit" href="" onclick="event.preventDefault(); llenarFormulario({{$loop->index}}, '#vtnGuardar')"></a></td>
                    </tr>
                @endforeach
            </table>

        {{-- Sin resultados --}}
        @else
            @include('plantillas.sin-resultados')
        @endif
    </form>

    {{-- Ventanas modales --}}
    {{-- Agregar --}}
    <div class="modal fade" id="{{$idVtn="vtnGuardar"}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{$tituloMD}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {{-- Campos --}}
                <div class="modal-body">

                    {{-- Id --}}
                    <input type="hidden" name="id" value="{{$id = uniqid()}}">
                    <input type="hidden" name="id_vtn" value="{{$idVtn}}">

                    {{-- Titulo --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='titulo')}}</label>
                            <input type="text" class="form-control" name="{{$n}}" maxlength="75" required>
                        </div>
                    </div>

                    {{-- Precio detal --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='precio_detal')}}</label>
                            <input class="form-control" name="{{$n}}" maxlength="6" onkeypress="soloNumeros(event)" required>
                        </div>
                    </div>

                    {{-- Compra mínima --}}
                    <div class="fila-form">
                        <div>
                            <label>{{__('textos.campos.' . $n='compra_min')}}</label>
                            <input class="form-control" name="{{$n}}" maxlength="3" onkeypress="soloNumeros(event)">
                        </div>
                        <div>
                            <label>{{__('textos.campos.' . $n='precio_detal')}}</label>
                            <input class="form-control" name="{{$n}}" maxlength="6" onkeypress="soloNumeros(event)">
                        </div>
                    </div>

                    {{-- Fotos --}}
                    @php($parametros=[
                        "limite_imgs"   =>  3,
                        "id_padre"      =>  $id,
                        "tipo_padre"    =>  "publicidad"
                    ])
                    <div
                        class="position-relative d-none align-items-center justify-content-center vp-img"
                        id="plantillaVPImg" ondragstart="capturar(event)" ondragenter="entrada(event)"
                        ondragover="gestorImgsMovimiento(event)" draggable="true"
                    >
                        <img src="">
                        <input type="hidden" name="iImg[]">
                        <label class="position-absolute btn btn-danger" onclick="gestorImgsEliminar(this)"><i class="fas fa-times"></i></label>
                        <div class="position-absolute d-none w-100 bg-danger text-white msj-error">Esta foto no se cargo correctamente</div>
                        <div class="position-absolute d-none align-items-center justify-content-center text-center barra-carga">Cargando...</div>
                    </div>

                    {{-- Gestor --}}
                    <h5 class="subtitulo-form">Imágenes <span id="numImgs">0</span> / <span id="limiteImgs">{{$parametros["limite_imgs"]}}</span></h5>
                    <div id="contImgs" class="d-flex flex-wrap align-items-center justify-content-center text-center py-4" ondragover="event.preventDefault()" ondrop="gestorImgsAgregar(event)">
                        <h6 class="w-100">
                            <i class="fas fa-upload"></i>
                            <br>
                            Puede arrastrar o
                            <label class="m-0 cursor-pointer">
                                <a href="" onclick="event.preventDefault(); this.nextElementSibling.click();">buscar</a>
                                <input type="file" class="d-none" accept="image/png,image/jpg,image/jpeg" onchange="gestorImgsAgregar(event)" multiple>
                            </label>
                            sus imagenes
                        </h6>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('textos.botones.cancelar')}}</button>
                    <button class="btn btn-primary">{{__('textos.botones.enviar')}}</button>
                </div>
            </form>
        </div>
    </div>
    {{-- Confirmación --}}
    @include('plantillas.ventana-confirmacion')
@endsection

{{-- JavaScript --}}
@section('js')
    <script src="{{asset('/js/formularios.js')}}"></script>
    <script>
        // Parametros
        var limiteImgs = {!! json_encode($parametros["limite_imgs"]) !!};
        var idPadre = {!! json_encode($parametros["id_padre"]) !!};
        var tipoPadre = {!! json_encode($parametros["tipo_padre"]) !!};
        // Vistas previas
        function gestorImgsAgregar(datos) {
            // Nuevo o existente
            // Nuevo
            if (nuevos = (typeof datos != "number")) {
                datos.preventDefault();
                var imgs = datos.target.files || datos.dataTransfer.files;
                var nImgs = imgs.length;
                var envios = [];
            }
            // Existentes
            else {
                var nImgs = datos;
            }
            // Por cada imagen...
            for (let i = 0; i < nImgs; i++) {
                // Límite de archivos
                if(contImgs.querySelectorAll('.vp-img').length >= limiteImgs){
                    alert("No puedes subir más de "+limiteImgs+" imágenes");
                    break;
                }
                // Muestro la miniatura
                contImgs.insertAdjacentElement('beforeend', vp = plantillaVPImg.cloneNode(true));
                vp.removeAttribute("id");
                vp.classList.replace("d-none","d-flex");
                // Asigno la imagen
                if (nuevos) {
                    vp.querySelector("img").src = (window.URL || window.webkitURL).createObjectURL(imgs[i]);
                }
                else {
                    vp.querySelector("img").src = "/img/"+tipoPadre+"/"+idPadre+"/"+i;
                }
                // Si es nuevo este valor se renueva con la respuesta del servidor
                vp.querySelector('[name="iImg[]"]').value = i;
                // Envio de imágenes al servidor si son nuevas
                if (nuevos) {
                    // Si no es una imagen
                    if (!['image/gif','image/jpeg','image/png'].includes(imgs[i].type)) {
                        continue;
                    }
                    // Preparo el formulario
                    var formulario = new FormData();
                    formulario.append("id",idPadre);
                    formulario.append("tipo",tipoPadre);
                    formulario.append("img",imgs[i]);
                    // Envio
                    (function(i,vp){
                        envios[i] = new XMLHttpRequest();
                        // Barra de progreso
                        envios[i].upload.addEventListener("progress",function(evt) {
                            if (evt.lengthComputable){
                                var valor = Math.round((evt.loaded / evt.total) * 100);
                                var barraCarga = vp.querySelector(".barra-carga");
                                barraCarga.classList.replace("d-none","d-flex");
                                barraCarga.innerHTML = valor+"%";
                                barraCarga.setAttribute("style","width: "+valor+"%");
                                if (valor==100) {
                                    setTimeout(() => { barraCarga.classList.replace("d-flex","d-none"); },500);
                                }
                            }
                        });
                        // Método
                        envios[i].open("POST","/img");
                        // Token CSRF
                        envios[i].setRequestHeader('X-CSRF-TOKEN',document.querySelector('meta[name="csrf-token"]').content);
                        // Envio
                        envios[i].send(formulario);
                        // Respuesta
                        envios[i].onreadystatechange = function(){
                            if (envios[i].readyState === 4){
                                if (envios[i].response && envios[i].status == 200) {
                                    vp.querySelector('[name="iImg[]"]').value = envios[i].response;
                                    // Mejorar esto con mensaje exitoso
                                }
                                else {
                                    vp.classList.add("vp-img-error");
                                }
                            }
                        }
                    })(i,vp);
                }
            }
            // Vacio el input
            if (nuevos) {
                datos.target.value = "";
            }
            // Ajusto el numerador
            numImgs.innerHTML = contImgs.querySelectorAll('.vp-img').length;
        }
        // Movimiento de elementos
        // Capturar
        var vpOrigen;
        function gestorImgsCapturar(event){
            vpOrigen = event.target;
            while (true){
                if (vpOrigen.classList.contains("vp-img")){ break; }
                else { vpOrigen = vpOrigen.parentNode; }
            }
        }
        var vpDestino;
        var iVPDestino;
        function gestorImgsEntrada(event){
            vpDestino = event.target;
            while (true) {
                if (vpDestino.classList.contains("vp-img")){ break; }
                else { vpDestino = vpDestino.parentNode; }
            }
        }
        // Mover y suelto
        function gestorImgsMovimiento(event){
            event.preventDefault();
            if(vpOrigen != vpDestino){
                // Sobre otro elemento
                if(vpDestino.classList.contains("vp-img")){
                    // Si esta a la derecha o izquiera del elemento
                    // Izquierda
                    if (event.pageX < (vpDestino.offsetLeft+(vpDestino.offsetWidth/2))){ var posicion = "beforebegin"; }
                    // Derecha
                    else { var posicion = "afterend"; }
                    vpDestino.insertAdjacentElement(posicion,vpOrigen);
                }
            }
        }
        // Eliminar
        function gestorImgsEliminar(btn) {
            // Elimino la vista previa
            contImgs.removeChild(btn.parentNode);
            // Ajusto el numerador
            numImgs.innerHTML = contImgs.querySelectorAll('.vp-img').length;
        }
    </script>
    <script>

        var registros       = @json($productos),
            registroA       = null,
            mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );
        if ( Object.keys(mensajesErrores).length || Object.keys(valoresErrores).length ) {
            llenarFormulario(null, (typeof valoresErrores.id_vtn === 'undefined') ? "" : '#' + valoresErrores.id_vtn);
        }

        // Campos adicionales
        function camposAdicionales(llenar, contFormulario) {

            // Llenar
            if (llenar) {

            }

            // Vaciar
            else {

            }
        }
    </script>
@endsection