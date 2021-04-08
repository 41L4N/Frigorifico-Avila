{{-- Estilos --}}
@section('estilos')
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
@append

{{-- Sub contenido --}}
{{-- Plantilla --}}
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

{{-- JavaScript --}}
@section('js')
    <script>

        // Parametros
        var limiteImgs = @json($parametros['limite_imgs']);
        var idPadre = @json($parametros['id_padre']);
        var tipoPadre = @json($parametros['tipo_padre']);

        // Vistas previas
        function gestorImgsAgregar(datos) {
            // Nuevo o existente
            // Nuevo
            if (nuevos = (typeof datos != 'number')) {
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
                vp.removeAttribute('id');
                vp.classList.replace('d-none', 'd-flex');
                // Asigno la imagen
                if (nuevos) {
                    vp.querySelector('img').src = (window.URL || window.webkitURL).createObjectURL(imgs[i]);
                }
                else {
                    vp.querySelector('img').src = '/img/'+tipoPadre+'/'+idPadre+'/'+i;
                }
                // Si es nuevo este valor se renueva con la respuesta del servidor
                vp.querySelector('[name="iImg[]"]').value = i;
                // Envio de imágenes al servidor si son nuevas
                if (nuevos) {
                    // Si no es una imagen
                    if (!['image/gif', 'image/jpeg', 'image/png'].includes(imgs[i].type)) {
                        continue;
                    }
                    // Preparo el formulario
                    var formulario = new FormData();
                    formulario.append('id', idPadre);
                    formulario.append('tipo', tipoPadre);
                    formulario.append('img', imgs[i]);
                    // Envio
                    (function(i,vp){
                        envios[i] = new XMLHttpRequest();
                        // Barra de progreso
                        envios[i].upload.addEventListener('progress', function(evt) {
                            if (evt.lengthComputable){
                                var valor = Math.round((evt.loaded / evt.total) * 100);
                                var barraCarga = vp.querySelector('.barra-carga');
                                barraCarga.classList.replace('d-none','d-flex');
                                barraCarga.innerHTML = valor+'%';
                                barraCarga.setAttribute('style','width: '+valor+'%');
                                if (valor==100) {
                                    setTimeout(() => { barraCarga.classList.replace('d-flex', 'd-none'); },500);
                                }
                            }
                        });
                        // Método
                        envios[i].open('POST', '/gestor-imgs');
                        // Token CSRF
                        envios[i].setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
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
                                    vp.classList.add('vp-img-error');
                                }
                            }
                        }
                    })(i,vp);
                }
            }
            // Vacio el input
            if (nuevos) {
                datos.target.value = '';
            }
            // Ajusto el numerador
            numImgs.innerHTML = contImgs.querySelectorAll('.vp-img').length;
        }

        // Eliminar
        function gestorImgsEliminar(btn) {
            // Elimino la vista previa
            btn.parentNode.remove();
            // Ajusto el numerador
            numImgs.innerHTML = contImgs.querySelectorAll('.vp-img').length;
        }
    </script>
@append