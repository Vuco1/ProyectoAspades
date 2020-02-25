var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var buttonpressed;
    $('.btn').click(function () {
        buttonpressed = $(this).attr('name');
        alert(buttonpressed);
    });

    function leer(e) {
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
    }
    ;


    function enviar(id) {
        document.forms[id].submit();
        //document.formulario.submit();                
    }

    /**
     * Todas las funciones que usamos con ajax.
     * @author Victor;
     */
    $('form').submit(function (evt) {
        //Funciones de las imagenes
        if (buttonpressed === 'btnsubcon') {
            alert('me cago en los muertos de ajax')
            //Para el submit de una imagen normal.
            if ($(this).find('input[name="accion"]').val() == 0) {
                alert('me cago en los muertos de ajax2')
                leer(evt);
                evt.preventDefault();

            }
            //Deja que el submit continue.
            if ($(this).find('input[name="accion"]').val() === 1) {
                leer(evt);
                setTimeout(function () {
                    enviar(id);
                }, 1800);
            }
            //Va hacia el subcontexto/contexto padre/anterior
            if ($(this).find('input[name="accion"]').val() === 2) {
                evt.preventDefault();
                $puntero = $(this).find('input[name="puntero"]').val();
                leer(evt);
                setTimeout(function () {
                    $.ajax({
                        url: 'irAnterior',
                        type: 'post',
                        data: {_token: CSRF_TOKEN, "puntero": $puntero},
                        success: function (response) {
                            alert('Usuario actualizado con exito');
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
                }, 1800);

            }
            //Vuelve al inicio
            if ($(this).find('input[name="accion"]').val() === 3) {
                evt.preventDefault();
                leer(evt);
                setTimeout(function () {
                    $.ajax({
                        url: 'obtenercontextos',
                        type: 'post',
                        data: {_token: CSRF_TOKEN},
                        success: function (response) {
                            alert('Usuario actualizado con exito');
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
                }, 1800);
            }
            //Va hacia otro contexto
            if ($(this).find('input[name="accion"]').val() === 4) {
                evt.preventDefault();
                var $id = $(this).find('input[name="contexto"]').val();
                $.ajax({
                    url: 'obtenerSubcontextos',
                    type: 'post',
                    data: {_token: CSRF_TOKEN, "puntero": $id},
                    success: function (response) {
                        alert('Usuario actualizado con exito');
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
        //Modificar usuarios en el CRUD de usuarios
        if (buttonpressed === 'modificar') {
            evt.preventDefault();
            var $id = $(this).find('input[name="Id"]').val();
            var $nombre = $(this).find('input[name="Nombre"]').val();
            var $nick = $(this).find('input[name="Nick"]').val();
            var $rol = $(this).find('select[name="Rol"]').val();
            $.ajax({
                url: 'updateUsuario',
                type: 'post',
                data: {_token: CSRF_TOKEN, "id": $id, "nombre": $nombre, "nick": $nick, "rol": $rol},
                success: function (response) {
                    alert('Usuario actualizado con exito');
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
        //Eliminar elementos del CRUD de usuarios
        if (buttonpressed === 'eliminar') {
            evt.preventDefault();
            var $id = $(this).find('input[name="Id"]').val();
            $.ajax({
                url: 'eliminarUsuario',
                type: 'post',
                data: {_token: CSRF_TOKEN, "id": $id},
                success: function (response) {
                    alert('Usuario eliminado con exito');
                    location.reload();
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
                    alert(msg);
                },
            });
        }

    });
//    
});