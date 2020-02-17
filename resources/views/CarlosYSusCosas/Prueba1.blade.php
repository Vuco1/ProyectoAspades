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
                $("formtab").submit(function (e) {
                    alert('entro');
                    formulario = $(this).attr('id');
                    alert(formulario);
                    e.preventDefault();
                    var id= formulario.substr(4);
                    alert('salgo');
                    alert(id);
                    var speech = new SpeechSynthesisUtterance();
                    // Set the text and voice attributes.
                    speech.text = document.getElementById("leer"+id).value;
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
            });
        </script>
    </head>
    <body>
        <form id="form0" name="formtab" action="prueba" method="post">
            @csrf
            <input id="leer0" type="text" value="Uno dos tres">
            <button>Enviar</button>
        </form>
        
        <form id="form1" name="formtab" action="prueba1" method="post">
            @csrf
            <input id="leer1" type="text" value="4 5 6">
            <input type="submit" value="Enviar">
        </form>
        
        <form id="form2" name="formtab" action="prueba2" method="post">
            @csrf
            <input id="leer2" type="text" value="7 8 9">
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>
