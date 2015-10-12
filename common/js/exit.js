// Mensaje al salir
window.onbeforeunload = preguntarAntesDeSalir;
function preguntarAntesDeSalir(){
    var bPreguntar = true;
    if (bPreguntar)
    return "¿Seguro que quiere salir del sistema?";
 }