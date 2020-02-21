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
     * @version 3.0
     */
    $("#loginadmin").click(function mostrarMenu() {
        var clave = $("#passw").val();
        var menu = $("#menuoculto");
        var botones = $(".card-footer");
        var numFilas = $("input[name=numfilas]").val();
        
        if (clave === "aspades") {
            if (menu.hasClass("d-none")) {
                $("#loginadmin").val("Ocultar menú");
                menu.removeClass("d-none").addClass("d-block");
                botones.removeClass("d-none").addClass("d-block");
                $(".card-img-top").css("height", "calc(100vh / " + numFilas + " - 6.775rem)");
            } else {
                $("#loginadmin").val("Mostrar menú");
                menu.removeClass("d-block").addClass("d-none");
                botones.removeClass("d-block").addClass("d-none");
                $(".card-img-top").css("height", "calc(100vh / " + numFilas + " - 2.75rem)");
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
    $("#idtablero").val($('#idtablero' + id).val());
}
function eliminarContexto(id) {
    $("#idelim").val($('#idtablero' + id).val());
}
function addContexto(id){}

function volver() {
    window.history.back();
}

