// Solo numeros y longitud maxima opcional
function soloNumeros(tecla) {
    var nuevoValor = tecla.target.value + tecla.key;
    if (
        // Valores permitidos
        tecla.keyCode < 47 || tecla.keyCode > 58
        // Cantidad de digitos
        || ( parseInt(nuevoValor.length) < parseInt(tecla.target.min.length) )
        || ( (tecla.target.max) ? parseInt(nuevoValor.length) > parseInt(tecla.target.max.length) : false )
        // Rango del valor
        || ( (tecla.target.min) ? parseInt(nuevoValor) < parseInt(tecla.target.min) : false )
        || ( (tecla.target.max) ? parseInt(nuevoValor) > parseInt(tecla.target.max) : false )
    ) {
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
    registroA = (clave===null) ? valoresErrores : registrosP[clave];

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