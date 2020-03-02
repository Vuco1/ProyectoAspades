/* 
 * Aquí van nuestros scripts
 */
/**
 * Muestra el menú y los botones de administración de tableros si ye eras administrador
 * @author Carlos
 * @version 3.0
 */
function menu() {
    var menu = $("#menuoculto");
    var botones = $(".card-footer");
    var numFilas = $("input[name=numfilas]").val();
    $("#divpass").addClass('d-none');
    $("#passw").val("aspades");
    $("#loginadmin").val("Ocultar menú");
    menu.removeClass("d-none").addClass("d-block");
    botones.removeClass("d-none").addClass("d-block");
    $(".card-img-top").css("height", "calc(100vh / " + numFilas + " - 6.775rem)");
    $("#loginoculto").modal("hide");
}

function comprobaradmin() {
    if (localStorage.getItem('admin')) {
        menu();
    }
}
function vaciarstorage() {
    localStorage.clear();
}
