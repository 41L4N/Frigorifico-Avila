// Limpiar formulario
$('#vtnGuardar').on('hide.bs.modal', function () {
    vtnGuardar.querySelector('form').reset();
    vtnGuardar.querySelectorAll('.is-invalid').forEach(campo => {
        campo.classList.remove('is-invalid');
    });
    if (errores = vtnGuardar.querySelector('#errores')) {
        errores.parentNode.removeChild(errores);
    }
});

// Errores
if (errores = document.querySelector('#errores')) {

    // Lista
    var errores = JSON.parse(errores.value);
    // Campos o valores
    Object.keys(errores).forEach(clave => {
        // Elementos
        Object.keys(errores[clave]).forEach(clave2 => {
            if (campo = document.querySelector('[name='+clave2+']')) {

                // Mensajes
                if (clave=="campos") {
                    campo.classList.add('is-invalid');
                    campo.insertAdjacentHTML('afterend','<div class="alert alert-danger m-0 mt-1">'+errores[clave][clave2][0]+'</div>');
                }

                // Valores
                else {
                    campo.value = errores[clave][clave2];
                }
            }
        });
    });
}

// Solo numeros
function soloNumeros(tecla) {
    if (tecla.keyCode < 47 || tecla.keyCode > 58) {
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