var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var buttonpressed;
    $('.formbutton').click(function () {
        buttonpressed = $(this).attr('name');
    });
    
    
    $('form').submit(function (evt) {
        evt.preventDefault();
        if (buttonpressed === 'modificar') {
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
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
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
        if (buttonpressed === 'eliminar') {
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
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
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