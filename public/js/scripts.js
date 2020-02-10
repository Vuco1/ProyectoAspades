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

});


