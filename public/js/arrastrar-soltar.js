var clase = 'arrastrar-soltar';
document.querySelectorAll('.'+clase).forEach(element => {
    element.setAttribute('ondragstart', 'capturar(event)')
    element.setAttribute('ondragenter', 'event.preventDefault()');
    element.setAttribute('ondragover', 'mover(event)')
});

// Capturar
var elementoActual;
function capturar(event){
    elementoActual = event.target;
    while (!elementoActual.classList.contains(clase)){
        elementoActual = elementoActual.parentNode;
    }
}

// Mover
function mover(event){
    event.preventDefault();

    // Elemento de destino
    elementoDestino = event.target;
    while (!elementoDestino.classList.contains(clase)){
        elementoDestino = elementoDestino.parentNode;
    }

    // Movimiento del elemento
    if(elementoActual != elementoDestino){

        // Cambio el elemento de lugar
        elementoDestino.insertAdjacentElement(
            // Si esta a la derecha o izquiera del elemento
            ( event.pageX < (elementoDestino.offsetLeft + elementoDestino.offsetWidth / 2) ) ? 'beforebegin' : 'afterend'
            , elementoActual
        );
        
    }
}