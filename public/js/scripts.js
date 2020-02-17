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

    //------------------------------------------------------------------------//

    $("form[name='formtablero']").submit(function (e) {
        alert('entro');
        formulario = $(this).attr('id');
        alert(formulario);
        e.preventDefault();
        var id = formulario.substr(4);
        alert('salgo');
        alert(id);
        var speech = new SpeechSynthesisUtterance();
        speech.text = document.getElementById("leer" + id).value;
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

    if (estilo.style.visibility === 'hidden') {
        if (clave === 'aspades') {
            document.getElementById("login").value ="Ocultar menú";
            estilo.style.visibility = "visible";
        }
    } else {
        document.getElementById("login").value ="Mostrar menú";
        estilo.style.visibility = "hidden";
        
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
}

