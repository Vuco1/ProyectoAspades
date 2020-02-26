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
            if ($("#clave").val() !== $("#claverepe").val() && $("#claverepe").val().length <= longitud) {
                $("#guardar").attr('disabled', true);
            } else {
                $("#mensaje").empty();
                $("#guardar").attr('disabled', false);
            }
        }
    });

    //------------------------------------------------------------------------//

    /**
     * Borrar el contenido de las ventana modal
     * @author Carlos.
     * @version 1.0 
     */
    $('.modal').on('hidden.bs.modal', function () {
        if ($(this).find('form')[0]) {
            $(this).find('form')[0].reset();
            $("label.error").remove();
        }
    });


    //------------------------------------------------------------------------//
    /**
     * Muestra el menú y los botones de administración de tableros si la contraseña es correcta.
     * @author Ampliado y adaptado a jquery por Laura.
     * @version 3.0
     */
    function menu() {
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
    }
    
    /**
     * Llama a la función menu() al hacer clic en el botón de logueo del administrador de tableros.
     */
    $("#loginadmin").click(function mostrarMenu() {
        menu();
    });
    
    /**
     * Llama a la función menu() al pulsar intro en el input de la contraseña del administrador de tableros.
     * @param {event} Nombre del evento. 
     * @author Carlos
     * @version 2.0 
     */
    $("#passw").keypress(function mostrarMenuIntro(event) {
        var tecla = event.keyCode;
        if (tecla === 13) {
            menu();
        }
    });
    
    function cambiarTextoBoton() {
        $(".custom-file-text").val("Hola");
    }
    /**
     * Sustituye el texto por defecto de los inputs de tipo file personalizados cuando se selecciona una imagen por el nombre de ésta.
     * @author Laura
     */
    $(".custom-file-input").change(function cambiarTexto() {
        var ruta = $(".custom-file-input").val();
        var texto = jQuery.trim(ruta).substr(12);
        $(".custom-file-label").text(texto);
    });

});

function modificarContexto(id) {
    $("#nombremod").val($('#nombre' + id).val());     
    $('#posimo').val(id);   
    $("#actual").val($('#actual' + id).val());
    var idaccion= $('#accion' + id).val() -1;
    document.getElementById('accionlist').options[idaccion].selected = 'selected';
}
function eliminarContexto(id) {
    $("#idelim").val($('#actual' + id).val());
}
function addContexto(id) {
    $('#posiadd').val(id);
}

function volver() {
    window.history.back();
}

