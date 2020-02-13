<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
        <script>
            $(document).ready(function () {
                $("#form").submit(function (e) {
                    formulario = $(this).attr('name');
                    e.preventDefault();
                    var speech = new SpeechSynthesisUtterance();
                    // Set the text and voice attributes.
                    speech.text = document.getElementById("leer").value;
                    speech.volume = 1;
                    speech.rate = 1;
                    speech.pitch = 1;
                    speech.lang = "es";
                    window.speechSynthesis.speak(speech);

                    setTimeout(function () {
                        enviar();
                    }, 3000);
                });
                function enviar() {
                    document.forms[0].submit();
                    //document.formulario.submit();                
                }
            });
        </script>
    </head>
    <body>
        <form id="form" name="form" action="prueba" method="post">
            @csrf
            <input id="leer" type="text" value="Uno dos tres">
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>
