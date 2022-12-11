// Desaparecer los mensajes de exito o error despues de 3 segundos
$(document).ready( function() {
    setTimeout( function() {
        $('.mensajesGET').fadeOut('slow');
    }, 3000);
} );

/**
 * Confirmar eliminacion de registro
 */
 function confirmar(event) {
    if ( confirm('¿Estás seguro de eliminar este registro?') ) {
        return true;
    } else {
        event.preventDefault();
    }
}

const eliminar = document.querySelectorAll('#eliminarRegistro');

// Detecta el evento submit
for(let i = 0; i < eliminar.length; i++) {
    eliminar[i].addEventListener('submit', confirmar);
}