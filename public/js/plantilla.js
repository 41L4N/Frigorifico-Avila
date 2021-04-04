// Lista de compras
function listaCompras(btn=null) {

    // Formulario actual
    if (btn) {

        var formulario = btn;
        while (!formulario.classList.contains('producto-lista-compras')) {
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
            success: function () {
                if (datosC.get('accion') == 2) {
                    formulario.remove();
                }
            }
        });
    }

    var total = 0,
        nCompras = 0;
    document.querySelectorAll('#vtnCompras .producto-lista-compras').forEach((formulario, iFormulario) => {
        
        // Subtotal
        var cantidad = formulario.querySelector('[name="cantidad"]').value;
        subtotal =  cantidad * formulario.querySelector('[name="precio_unitario"]').value;
        formulario.querySelector('.subtotal').innerHTML = (subtotalTexto = "$" + subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'));
        if (typeof (celdaSubtotal = document.querySelectorAll('.subtotal-orden-compra')[iFormulario]) != 'undefined') {
            celdaSubtotal.innerHTML = subtotalTexto;
        }

        // Total
        total = total + subtotal;
        precioTotal.innerHTML = "$" + total.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        // if (condition) {
            
        // }

        // Numero de compras
        nCompras = nCompras + parseInt(cantidad);
        document.querySelectorAll('.n-compras').forEach(campoNCompras => {
            console.log(nCompras);
            campoNCompras.innerHTML = nCompras;
        });
    });
}

// Funciones automaticas despues de cargar el archivo
document.addEventListener('DOMContentLoaded', function() {

    // Lista de compras
    listaCompras();
    
    // Mostrar errores
    if (typeof mensajesErrores !='undefined' && typeof valoresErrores != 'undefined') {
        if ( Object.keys(mensajesErrores).length || Object.keys(valoresErrores).length ) {
            llenarFormulario(null, (typeof valoresErrores.id_vtn === 'undefined') ? "" : '#' + valoresErrores.id_vtn);
        }
    }

    // Limpiar formulario
    document.querySelectorAll('.contenido .modal').forEach(contFormulario => {
        $('#'+contFormulario.id).on('hide.bs.modal', function () {
            // Campos
            contFormulario.querySelector('form').reset();
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
                alerta.parentNode.removeChild(alerta);
            });
        });
    });
 }, false);