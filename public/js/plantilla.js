// Lista de compras
function listaCompras(btn=null) {

    // Formulario actual
    if (btn) {

        var formulario = btn;
        while (formulario.tagName != 'FORM') {
            formulario = formulario.parentNode;
        }

        // Validacion
        if (!formulario.checkValidity()) {
            return;
        }

        // Envio
        $.ajax({
            type: "POST",
            url: formulario.action,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content
            },
            data: datosC = new FormData(formulario),
            processData: false,
            contentType: false,
            success: function (r) {
                if (r == 2) {
                    formulario.remove();
                }
            }
        });
    }

    var total = 0,
        nCompras = 0;
    document.querySelectorAll('.producto-lista-compras').forEach(formulario => {

        // Subtotal
        subtotal = formulario.querySelector('[name="cantidad"]').value * formulario.querySelector('[name="precio_unitario"]').value;
        formulario.querySelector('.subtotal').innerHTML = "$" + subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

        // Total
        total = total + subtotal;
        precioTotal.innerHTML = "$" + total.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

        // Numero de compras
        document.querySelector('.btn-compras span').innerHTML = (nCompras = nCompras + parseInt(formulario.querySelector('[name="cantidad"]').value) )
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