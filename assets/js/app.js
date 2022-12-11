function confirmar(e){if(confirm("¿Estás seguro de eliminar este registro?"))return!0;e.preventDefault()}$(document).ready((function(){setTimeout((function(){$(".mensajesGET").fadeOut("slow")}),3e3)}));const eliminar=document.querySelectorAll("#eliminarRegistro");for(let e=0;e<eliminar.length;e++)eliminar[e].addEventListener("submit",confirmar);
//# sourceMappingURL=app.js.map
