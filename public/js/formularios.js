// Solo numeros y longitud maxima opcional
function soloNumeros(tecla, longitud=null) {
    if (tecla.keyCode < 47 || tecla.keyCode > 58 || (longitud) ? tecla.target.value.length > longitud : null ) {
        tecla.returnValue = false;
    }
}

// Funcion de activar todos los checks dentro de la tabla donde fue activado el check principal ubicada por la clase ".tb-resultados"
var checks = document.querySelectorAll('.tb-resultados [name^="resultado"]');
function clickTodos(){ checks.forEach(check => { check.checked = checkPrincipal.checked; }); }

// Contar checks
function contarChecks(){

    // Activar/Desactivar el check principal
    var numChecksActivos = document.querySelectorAll('.tb-resultados [name^="resultado"]:checked').length;
    if(numChecksActivos == checks.length){ checkPrincipal.checked = true; }
    else { checkPrincipal.checked = false; }

    // Gestionar las opciones
    if(numChecksActivos > 0){ var estatus = false; }
    else { var estatus = true; }
    document.querySelectorAll('.btn-admin').forEach(btn => { btn.disabled = estatus; });
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

// Registro actual
function llenarFormulario(clave=null, contFormulario) {

    // Posibles errores
    Object.keys(mensajesErrores).forEach(clave => {
        if ( campo = document.querySelector(contFormulario + ' [name=' + clave + ']') ) {
            // Estilos
            campo.classList.add('is-invalid');
            // Mensaje
            campo.insertAdjacentHTML('afterend', '<div class="alert alert-danger m-0 mt-1">' + mensajesErrores[clave][0] + '</div>');
        }
    });

    // Registro actual
    registroA = (clave===null) ? valoresErrores : registros[clave];

    // Campos directos
    Object.keys(registroA).forEach(clave => {
        if ( campo = document.querySelector(contFormulario + ' [name=' + clave + ']') ) {

            // Según el tipo de campo
            if (['checkbox','ratio'].includes(campo.type)) {
                campo.checked = true;
            }
            else {
                campo.value = registroA[clave];
            }
        }
    });

    // Campos adicionales
    if (typeof camposAdicionales !== 'undefined') {
        camposAdicionales(true, contFormulario);
    }

    // Ventana
    $(contFormulario).modal('show');
}

// Acción
if (typeof mensajesErrores !='undefined' && typeof valoresErrores != 'undefined') {
    if ( Object.keys(mensajesErrores).length || Object.keys(valoresErrores).length ) {
        llenarFormulario(null, (typeof valoresErrores.id_vtn === 'undefined') ? "" : '#' + valoresErrores.id_vtn);
    }
}