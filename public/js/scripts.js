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
            localStorage.setItem('admin',true);
            if (menu.hasClass("d-none")) {
                $("#loginadmin").val("Ocultar menú");
                menu.removeClass("d-none").addClass("d-block");
                botones.removeClass("d-none").addClass("d-block");
                $(".card-img-top").css("height", "calc(100vh / " + numFilas + " - 6.775rem)");
            } else {
                localStorage.removeItem('admin');
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

/**
 * Modifica el contenido de la ventana modal con los datos que tiene la tarjeta
 * @param {type} id
 * @returns {undefined}
 * @author Victor
 */
function modificarContexto(id) {
    $("#nombremod").val($('#nombre' + id).val());
    $('#posimo').val(id);
    $("#actual").val($('#actual' + id).val());
    var idaccion = $('#accion' + id).val() - 1;
    document.getElementById('accionlist').options[idaccion].selected = 'selected';
}
/**
 * Pasa la id a la ventana modal de eliminar.
 * @param {type} id
 * @returns {undefined}
 * @author Victor
 */
function eliminarContexto(id) {
    $("#idelim").val($('#actual' + id).val());
}
/**
 * Pasa la posicion a la ventana modal de añadir.
 * @param {type} id
 * @returns {undefined}
 * @author Victor
 */
function addContexto(id) {
    $('#posiadd').val(id);
}
/**
 * Obtiene la pagina actual
 * @param {type} id
 * @returns {undefined}
 * @author Victor, Carlos, Laura
 */
function eliminarPagina() {
    var cosa = $("ol.carousel-indicators li.active").attr('id');
    cosa = cosa.substr(3);
    $("#elimpagina").val(cosa);
}

function volver() {
    window.history.back();
}

