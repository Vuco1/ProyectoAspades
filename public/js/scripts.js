/* 
 * Aquí van nuestros scripts
 */
$(document).ready(function () {

    /**
     * Valida el contenido de los campos de clave y repetir clave del perfil de administrador.
     * @author Laura
     */
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

    //------------------------------------------------------------------------//

    $("form[name='formtablero']").submit(function (e) {
        formulario = $(this).attr('id');
        e.preventDefault();
        var id = formulario.substr(4);
        var speech = new SpeechSynthesisUtterance();
        speech.text = document.getElementById("leer" + id).textContent;
        speech.volume = 1;
        speech.rate = 1;
        speech.pitch = 1;
        speech.lang = "es";
        window.speechSynthesis.speak(speech);

        setTimeout(function () {
            enviar(id);
        }, 3000);
    });

    function enviar(id) {
        document.forms[id].submit();
        //document.formulario.submit();                
    }

    $("img[name='imagen']").click(function () {
        var speech = new SpeechSynthesisUtterance();
        speech.text = this.value;
        speech.volume = 1;
        speech.rate = 1;
        speech.pitch = 1;
        speech.lang = "es";
        window.speechSynthesis.speak(speech);
    });

    //------------------------------------------------------------------------//
    /**
     * Muestra el menú y los botones de administración de tableros si la contraseña es correcta.
     * @author Ampliado y adaptado a jquery por Laura.
     * @version 2.0
     */
    $("#loginadmin").click(function mostrarMenu() {
        var clave = $("#passw").val();
        var menu = $("#menuoculto");
        var botones = $(".card-footer");

        if (clave === "aspades") {
            if (menu.hasClass("d-none")) {
                $("#loginadmin").val("Ocultar menú");
                menu.removeClass("d-none").addClass("d-block");
                botones.removeClass("d-none").addClass("d-block");
            } else {
                $("#loginadmin").val("Mostrar menú");
                menu.removeClass("d-block").addClass("d-none");
                botones.removeClass("d-block").addClass("d-none");
                $("#passw").val("");
            }
            $("#loginoculto").modal("hide");
        }
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

//----------------------------------------------------------------------------//
//Vista -> Inicio usuario.
//Author: Isa

/**
 * En el inicio de sesión del usuario normal, al meter la contraseña en la ventana modal, 
 * redirecciona a las dos funciones que se recogen aquí.
 * @author Isabel
 */
//function comprobar() {
//    mostrarMenu();
//    cerrarVentana();
//}

///**
// * Muestra el menú oculto del usuario normal si la contraseña coincide.
// * @author Isabel
// * @deprecated
// */
//function mostrarMenu() {
//    var clave = document.getElementById("passw").value;
//    var estilo = document.getElementById("menuoculto");
//
//    if (estilo.style.display === 'none') {
//        if (clave === 'aspades') {
//            document.getElementById("login").value ="Ocultar menú";
//            estilo.style.display = "block";
//        }
//    } else {
//        document.getElementById("login").value ="Mostrar menú";
//        estilo.style.display = "none";       
//    }
//}

///**
// * Cierra la ventana modal del usuario normal tras comprobar que la contraseña coincide.
// * @return {undefined}
// */
//function cerrarVentana() {
//    $('#login').click(function () {
//        $('#loginOculto').modal('hide');
//    });
//
//    $('#carouselContextos').on('slide.bs.carousel', function () {
//        currentIndex = $('div.active').index() + 1;
//        $('.num').html('' + currentIndex + '/' + totalItems + '');
//    });
//}

