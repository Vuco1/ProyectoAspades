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


    $("#c1").click(function () {
        $("#menuoculto").hide(1500);
    });

    //Mostrar bloque
    $("#c2").click(function () {
        $("#menuoculto").show(1000);
        $("#menuoculto").attr('style', 'display:flex');
    });

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

function volver() {
    window.history.back();
}


