/* 
 * Aquí van nuestros scripts
 */
$(document).ready(function () {
    
    //Valida el contenido de los campos de clave y repetir clave del perfil de administrador.
    $("#claverepe").blur(function validarClave() {
        var mensaje = "Las contraseñas no coinciden";
        if ($("#clave").val() !== $("#claverepe").val()) {
            $("#mensaje").html(mensaje);
            $("#guardar").attr('disabled', true);
        } else {
            $("#mensaje").empty();
            $("#guardar").attr('disabled', false);
        }
    });
    
});


