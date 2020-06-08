var CSRF_TOKEN = $('meta[name="csrf_token"]').attr('content');

$(document).ready(function () {
//    $.ajaxSetup({
//        headers: {
//            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
//        }
//    });
    /** Muestra el menú y los botones de administración de tableros si ye eras administrador
     * @author Carlos
     * @version 3.0
     */
    if (localStorage.getItem('admin')) {
        menu();
    }

    function menu() {
        var menu = $("#menuoculto");
        var botones = $(".card-footer");
        var numFilas = $("input[name=numfilas]").val();
        var candado = $("#candado");
        $("#divpass").addClass('d-none');
        $("#passw").val("aspades");
        $("#loginadmin").val("Hide menu");
        candado.removeClass("fa-lock").addClass("fa-unlock");
        menu.removeClass("d-none").addClass("d-block");
        botones.removeClass("d-none").addClass("d-block");
        $(".card-img-top").css("height", "calc(100vh / " + numFilas + " - 6.775rem)");
        $("#loginoculto").modal("hide");
    }
    /**
     * Difrerencia el tipo de boton pulsado
     * @type jQuery
     * @author Victor y Carlos
     */
    var buttonpressed;
    $('.btn').click(function () {
        buttonpressed = $(this).attr('name');
    });

    /**
     * Lee el texto de la carta 
     * @param {type} e
     * @param {type} form
     * @author Carlos
     */
    function leer(e, form) {
        var formulario = $(form).attr('id');
        e.preventDefault();
        var id = formulario.substr(4);
        localStorage.setItem('id', id);
        var speech = new SpeechSynthesisUtterance();
        speech.text = document.getElementById("leer" + id).textContent;
        speech.volume = 1;
        speech.rate = 1;
        speech.pitch = 1;
        speech.lang = "en";
        window.speechSynthesis.speak(speech);
    }
    ;

    function enviar() {
        var id = localStorage.getItem('id');
        localStorage.removeItem('id');
        document.forms[id].submit();
        //document.formulario.submit();                
    }
    function enviarsubcontextos() {
        var id = localStorage.getItem('id');
        localStorage.removeItem('id');
        document.forms[id].submit();
        //document.formulario.submit();                
    }

    /**
     * Todas las funciones que usamos con ajax.
     * @author Victor
     */
    $('form').submit(function (evt) {
        //Funciones de las imagenes
        if (buttonpressed === 'btnsubcon') {
            //Para el submit de una imagen normal.
            if ($(this).find('input[name="accion"]').val() == 1 || $(this).find('input[name="accion"]').val() == 0) {
                leer(evt, this);
                evt.preventDefault();
            }
            //Deja que el submit continue.
            if ($(this).find('input[name="accion"]').val() == 2) {
                leer(evt, this);
                setTimeout(function () {
                    enviarsubcontextos();
                }, 1800);
            }
            //Va hacia el subcontexto/contexto padre/anterior
            if ($(this).find('input[name="accion"]').val() == 3) {
                leer(evt, this);
                evt.preventDefault();
                var anterior = $(this).find('input[name="anterior"]').val();
                setTimeout(function () {
                    window.history.back();
//                    $.ajax({
//                        url: 'irAnterior',
//                        type: 'post',
//                        data: {_token: CSRF_TOKEN, "anterior": anterior,},
//                        success: function (response) {
//                            
//                        }, error: function (jqXHR, exception) {
//                            var msg = '';
//                            if (jqXHR.status === 0) {
//                                msg = 'Not connect.\n Verify Network.';
//                            } else if (jqXHR.status === 404) {
//                                msg = 'Requested page not found. [404]';
//                            } else if (jqXHR.status === 500) {
//                                msg = 'Internal Server Error [500].';
//                            } else if (exception === 'parsererror') {
//                                msg = 'Requested JSON parse failed.';
//                            } else if (exception === 'timeout') {
//                                msg = 'Time out error.';
//                            } else if (exception === 'abort') {
//                                msg = 'Ajax request aborted.';
//                            } else {
//                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
//                            }
//                        },
//                    });
                }, 1800);

            }
            //Vuelve al inicio
            if ($(this).find('input[name="accion"]').val() == 4) {
                evt.preventDefault();
                leer(evt, this);
                setTimeout(function () {
                    location.href = "obtenercontextos";
//                    $.ajax({
//                        url: 'obtenercontextos',
//                        type: 'post',
//                        data: {_token: CSRF_TOKEN},
//                        success: function (response) {
//                            alert('Usuario actualizado con exito');
//                        }, error: function (jqXHR, exception) {
//                            var msg = '';
//                            if (jqXHR.status === 0) {
//                                msg = 'Not connect.\n Verify Network.';
//                            } else if (jqXHR.status === 404) {
//                                msg = 'Requested page not found. [404]';
//                            } else if (jqXHR.status === 500) {
//                                msg = 'Internal Server Error [500].';
//                            } else if (exception === 'parsererror') {
//                                msg = 'Requested JSON parse failed.';
//                            } else if (exception === 'timeout') {
//                                msg = 'Time out error.';
//                            } else if (exception === 'abort') {
//                                msg = 'Ajax request aborted.';
//                            } else {
//                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
//                            }
//                        },
//                    });
                }, 1800);
            }
            //Va hacia otro contexto
            if ($(this).find('input[name="accion"]').val() === 5) {
                evt.preventDefault();
                var $id = $(this).find('input[name="contexto"]').val();
                $.ajax({
                    url: 'obtenerSubcontextos',
                    type: 'post',
                    data: {_token: CSRF_TOKEN, "puntero": $id},
                    success: function (response) {
                    }, error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status === 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status === 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                    },
                });
            }
        }
        if (buttonpressed === 'btncon' || buttonpressed === 'btninicio') {
            leer(evt, this);
            setTimeout(function () {
                enviar();
            }, 1800);
        }
        //Modificar usuarios en el CRUD de usuarios
//        if (buttonpressed === 'guardarmod') {
//            evt.preventDefault();           
//            var id = $('#idusumod').val();
//            var nick = $('#usuariomod').val();
//            var nombre = $('#nombremod').val();
//            var rol = $('#rolmod').val();
//            var clave = $('#clavemod').val();
//            var imagen = $('#imagenmod').val();
//            $.ajax({
//                url: 'updateusuario',
//                type: 'post',
//                data: {_token: CSRF_TOKEN, "id": id, "nick": nick, "nombre": nombre, "rol": rol, "clave": clave, "imagen": imagen},
//                success: function (response) {
//                    alert(response);
//                    location.reload();
//                }, error: function (jqXHR, exception) {
//                    var msg = '';
//                    if (jqXHR.status === 0) {
//                        msg = 'Not connect.\n Verify Network.';
//                    } else if (jqXHR.status === 404) {
//                        msg = 'Requested page not found. [404]';
//                    } else if (jqXHR.status === 500) {
//                        msg = 'Internal Server Error [500].';
//                    } else if (exception === 'parsererror') {
//                        msg = 'Requested JSON parse failed.';
//                    } else if (exception === 'timeout') {
//                        msg = 'Time out error.';
//                    } else if (exception === 'abort') {
//                        msg = 'Ajax request aborted.';
//                    } else {
//                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
//                    }
//                },
//            });
//        }
        //Eliminar elementos del CRUD de usuarios
//        if (buttonpressed === 'delete') {
//            evt.preventDefault();
//            var $id = $(this).find('input[name="idusuelim"]').val();
//            $.ajax({
//                url: 'eliminarUsuario',
//                type: 'post',
//                data: {_token: CSRF_TOKEN, "id": $id},
//                success: function (response) {
//                    location.reload();
//                }, error: function (jqXHR, exception) {
//                    var msg = '';
//                    if (jqXHR.status === 0) {
//                        msg = 'Not connect.\n Verify Network.';
//                    } else if (jqXHR.status === 404) {
//                        msg = 'Requested page not found. [404]';
//                    } else if (jqXHR.status === 500) {
//                        msg = 'Internal Server Error [500].';
//                    } else if (exception === 'parsererror') {
//                        msg = 'Requested JSON parse failed.';
//                    } else if (exception === 'timeout') {
//                        msg = 'Time out error.';
//                    } else if (exception === 'abort') {
//                        msg = 'Ajax request aborted.';
//                    } else {
//                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
//                    }
//                    alert(msg);
//                },
//            });
//        }

    });
//    
});
function vaciarstorage() {
    localStorage.clear();
}
