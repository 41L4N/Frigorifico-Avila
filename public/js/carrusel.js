// Movimiento del carrusel
function moverCarrusel(btn, direccion) {

    // Carrusel
    var carrusel = btn.parentNode;
    while (!carrusel.classList.contains('carrusel')) {
        carrusel = carrusel.parentNode;
    }

    // Secciones del carrusel
    var contItemsCarrusel = carrusel.querySelector('.cont-items-carrusel');
    var itemsCarrusel = contItemsCarrusel.querySelectorAll(':scope > *');
    var medida = itemsCarrusel[0].clientWidth;
    var limite = (contItemsCarrusel.clientWidth - carrusel.clientWidth) * -1;
    if (itemsCarrusel.length > 1) {

        // Numero de secciones del carrusel
        // var ncontItemsCarrusel = contItemsCarrusel.length-1;

        // Elemento específico
        if (typeof direccion == 'number') {
            console.log("number");
        }

        // Direcciones
        else {
            var margen = (contItemsCarrusel.currentStyle || window.getComputedStyle(contItemsCarrusel));
            margen = margen.marginLeft;
            margen = margen.replace('px','');
            margen = parseInt(margen);
            margen = eval( margen + direccion + medida );
            if (margen > 0) { margen = 0; }
            if (margen < limite) { margen = limite; }
            contItemsCarrusel.setAttribute('style', 'margin-left: ' + margen + 'px;');
        }
    }

    // Reinicio del tiempo
    // clearInterval(tiempo);
    // tiempo = setInterval(() => {
    //     carrusel.querySelector(".flecha-derecha").click();
    // },5000);
}

// Reproduccion automatica
// array.forEach(element => {
//     if (carrusel = document.querySelector(".carrusel")) {
//         var tiempo = setInterval(() => {
//             carrusel.querySelector(".flecha-derecha").click();
//         },5000);
//     }
// });