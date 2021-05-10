// Lista de compras
function actualizarListaCompras(btn=null) {

    // Formulario actual
    if (btn) {

        var formulario = btn;
        while (!formulario.classList.contains('producto-lista-productos')) {
            formulario = formulario.parentNode;
        }

        // Validacion
        (camposF = formulario.querySelectorAll('input')).forEach(input => {
            if (!input.checkValidity()) {
                return;
            }
        });

        // Datos de la compra
        var datosC = new FormData();
        camposF.forEach(campo => {
            datosC.set(campo.name, campo.value);
        });

        // Envio
        $.ajax({
            type: "POST",
            url: '/lista-compras',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content
            },
            data: datosC,
            processData: false,
            contentType: false,
            success: function (r) {
                switch (datosC.get('accion')) {

                    // Agregar
                    case "0":
                        $('#vtnListaCompras').modal('show');
                    break;

                    // Eliminar
                    case "2":
                        formulario.remove();
                    break;
                }

                // Actualizar información
                listaCompras = r;
                actualizarListaCompras();
            }
        });
    }

    else {

        // Alerta
        document.querySelector('#vtnListaCompras .alert').innerHTML = listaCompras.msjAlerta;

        // Renovar productos
        if (typeof contListaCompras === 'undefined') {
            return;
        }
        if (typeof listaCompras.productos !== 'undefined') {
            contListaCompras.innerHTML = "";

            // Lista de productos
            listaCompras.productos.forEach((p, iP) => {

                // Nuevo producto
                var nuevoP = ejemploProductoListaCompras.cloneNode(true);

                // Id
                nuevoP.removeAttribute('id');
                // Visibilidad
                nuevoP.classList.remove('d-none');

                // Tipo
                nuevoP.querySelector('[name="tipo"]').value = p.tipo;
                // ID
                nuevoP.querySelector('[name="id"]').value = p.id;
                // Enlace
                nuevoP.querySelector('a.cont-min-img').href = ruta = "/"+p.tipo+"/"+p.alias+"/"+p.id;
                // Imágen
                nuevoP.querySelector('a.cont-min-img img').src = "/img/"+p.tipo+"/"+p.id;
                // Numerador
                nuevoP.querySelector('b.numerador').innerHTML = ++iP;
                // Precio unitario
                nuevoP.querySelector('.precio-unitario').innerHTML = p.precio_unitario_p;
                // Titulo
                nuevoP.querySelector('.titulo').href = ruta;
                nuevoP.querySelector('.titulo').innerHTML = p.titulo;
                // Cantidad
                nuevoP.querySelector('[name="cantidad"]').value = p.cantidad;
                // Subtotal
                nuevoP.querySelector('.subtotal').innerHTML = p.subtotal;

                // Mostrar
                contListaCompras.insertAdjacentElement('beforeend', nuevoP);
            });
        }

        // Total
        if (contTotal = document.querySelector('.precio-total')) {
            contTotal.innerHTML = listaCompras.total.texto;
        }
        // Numerador de compras
        if (contNCompras = document.querySelector('.n-compras')) {
            contNCompras.innerHTML = listaCompras.nCompras;
        }
    }
}

// Funciones automaticas despues de cargar el archivo
document.addEventListener('DOMContentLoaded', function() {

    // Lista de compras
    actualizarListaCompras();

    // Mostrar errores
    if (typeof mensajesErrores == 'object' && mensajesErrores && typeof valoresErrores == 'object' && valoresErrores) {
        if ( Object.keys(mensajesErrores).length || Object.keys(valoresErrores).length ) {
            llenarFormulario(null, (typeof valoresErrores.id_vtn === 'undefined') ? "" : '#' + valoresErrores.id_vtn);
        }
    }

    // Limpiar formulario
    document.querySelectorAll('.contenido .modal').forEach(contFormulario => {
        $('#'+contFormulario.id).on('hide.bs.modal', function () {

            // Campos
            if (formulario = contFormulario.querySelector('form')) {
                formulario.reset();
            }
            // Campos adicionales
            if (typeof camposAdicionales !== 'undefined') {
                camposAdicionales(false, contFormulario)
            }
            // Estilos
            contFormulario.querySelectorAll('.is-invalid').forEach(campo => {
                campo.classList.remove('is-invalid');
            });
            // Alertas
            contFormulario.querySelectorAll('.alert').forEach(alerta => {
                alerta.remove();
            });
        });
    });
 }, false);