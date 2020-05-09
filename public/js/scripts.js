/* 
 * Aquí van nuestros scripts
 */
$(document).ready(function () {

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
     * @author Carlos, Isabel y Laura.
     * @version 3.1
     */
    function menu() {
        var clave = $("#passw").val();
        var menu = $("#menuoculto");
        var botones = $(".card-footer");
        var numFilas = $("input[name=numfilas]").val();
        var candado = $("#candado");
        if (clave === "aspades") {
            localStorage.setItem('admin', true);
            if (menu.hasClass("d-none")) {
                $("#divpass").addClass('d-none');
                $("#loginadmin").val("Ocultar menú");
                menu.removeClass("d-none").addClass("d-block");
                candado.removeClass("fa-lock").addClass("fa-unlock");                
                botones.removeClass("d-none").addClass("d-block");
                $(".card-img-top").css("height", "calc(100vh / " + numFilas + " - 6.775rem)");
            } else {
                $("#divpass").removeClass('d-none');
                localStorage.removeItem('admin');
                $("#loginadmin").val("Mostrar menú");
                menu.removeClass("d-block").addClass("d-none");
                candado.removeClass("fa-unlock").addClass("fa-lock");
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


});

/**
 * Valida el contenido de los campos de clave y repetir clave del perfil de administrador.
 * @author Laura
 * @version 2.1
 */
function validarClave(accion) {
    var mensaje = "Las contraseñas no coinciden";
    var longitud = $("#clave" + accion).val().length;
    var clave = $("#clave" + accion).val();
    var claverepe = $("#claverepe" + accion).val();
    
    if (clave !== claverepe && claverepe.length >= longitud) {
        $("#mensaje" + accion).html(mensaje);
        $("#mensaje" + accion).removeClass("text-success");
        $("#mensaje" + accion).addClass("text-danger"); 
        $("#guardar" + accion).attr('disabled', true);
    } else {
        if (clave !== claverepe && claverepe.length <= longitud) {
            $("#guardar" + accion).attr('disabled', true);
        } else {
            $("#mensaje" + accion).empty();
            $("#mensaje" + accion).removeClass("text-danger");
            $("#mensaje" + accion).addClass("text-success");
            $("#guardar" + accion).attr('disabled', false);
        }
    }
}

//----------------------------------------------------------------------------//

/**
 * Sustituye el texto por defecto de los inputs de tipo file personalizados cuando se selecciona una imagen por el nombre de ésta.
 * @param id Id del input en el que se produce el evento
 * @author Laura
 * @version 2.0
 */
function cambiarTexto(id) {
    var ruta = $("input[id='" + id + "']").val();
    var texto = jQuery.trim(ruta).substr(12);
    $("label[id='" + id + "label']").text(texto);
}

//----------------------------------------------------------------------------//

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

/**
 * Establece id como valor del input idusuelim del la ventana de confirmación de eliminación de usuario.
 * @param id Número identificador del usuario
 * @author Laura
 */
function eliminarUsuario(id) {
    $("#idusuelim").val(id);
}

/**
 * Establece id como valor del input idusuelim del la ventana de confirmación de eliminación de usuario.
 * @param id Número identificador del usuario
 * @param rol Tipo de permisos del usuario   
 * @author Laura
 */
function editarUsuario(id, rol) {
    $("#idusumod").val(id);
    $("#usuariomod").val($("#nick" + id).val());
    $("#nombremod").val($("#nombre" + id).val());
    $("#idrol").val(rol);
    $("#rolmod").val(rol);
}