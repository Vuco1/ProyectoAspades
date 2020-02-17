/* 
 * Aquí van nuestros scripts
 */
$(document).ready(function () {

    //Valida el contenido de los campos de clave y repetir clave del perfil de administrador.
    $("#claverepe").keyup(function validarClave() {
        var mensaje = "Las contraseñas no coinciden";
        var longitud = $("#clave").val().length;
        if ($("#clave").val() !== $("#claverepe").val() && $("#claverepe").val().length >= longitud) {
            $("#mensaje").html(mensaje);
            $("#guardar").attr('disabled', true);
        } else {
            $("#mensaje").empty();
            $("#guardar").attr('disabled', false);
        }
    });

    //Mostrar bloque
    $("#c2").click(function () {
        $("#menuoculto").show(1000);
        $("#menuoculto").attr('style', 'display:flex');
    });


});
function modificarContexto(id) {
    $("#imgcontexto").attr('src', $('#img' + id).attr('src'));
    $("#nombrecontexto").val($('#nombre' + id).val());
    $("#idimg").val(id);
}
function eliminarContexto(id) {
    $("#idelim").val(id);
}

function volver() {
    window.history.back();
}

//Vista -> Inicio usuario.
//Author: Isa

/**
 * En el inicio de sesión del usuario normal, al meter la contraseña en la ventana modal, 
 * redirecciona a las dos funciones que se recogen aquí.
 * @return {undefined}
 */
function comprobar() {
    mostrarMenu();
    cerrarVentana();
}

/**
 * Muestra el menú oculto del usuario normal si la contraseña coincide.
 * @return {undefined}
 */
function mostrarMenu() {
    var clave = document.getElementById("passw").value;
    var estilo = document.getElementById("menuoculto");

    if (estilo.style.display === 'none') {
        if (clave === 'aspades') {
            document.getElementById("login").value ="Ocultar menú";
            estilo.style.display = "contents";
        }
    } else {
        document.getElementById("login").value ="Mostrar menú";
        estilo.style.display = "none";
        
    }
}

/**
 * Cierra la ventana modal del usuario normal tras comprobar que la contraseña coincide.
 * @return {undefined}
 */
function cerrarVentana() {
    $('#login').click(function () {
        $('#loginOculto').modal('hide');
    });
    
      $('#carouselContextos').on('slide.bs.carousel', function () {
        currentIndex = $('div.active').index() + 1;
        $('.num').html('' + currentIndex + '/' + totalItems + '');
    });
}

