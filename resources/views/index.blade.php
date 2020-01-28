<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script src="{{asset("js/jquery-3.4.1.min.js")}}"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <script>
function cambiarTam() {
    var foto = document.getElementById("img1");
    foto.width = document.getElementById("ancho").value;
    foto.height = document.getElementById("alto").value;
}

async function hablar() {
    var speech = new SpeechSynthesisUtterance();
    speech.text = document.getElementById("leer").value;
    speech.volume = 1;
    speech.rate = 1;
    speech.pitch = 1;
    speech.lang = "es";
    window.speechSynthesis.speak(speech);
    await sleep(9000);
    formulario.submit();
    return true;
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

/**function enviar() {
 var formulario = document.getElementById("form");
 var speech = new SpeechSynthesisUtterance();
 
 speech.text = document.getElementById("leer").value;
 speech.volume = 1;
 speech.rate = 1;
 speech.pitch = 1;
 speech.lang = "es";
 window.speechSynthesis.speak(speech);
 setTimeout(null, 'tres second later', 3000);
 formulario.submit();
 return true;
 }
 
 $("form").submit(function (e) {
 
 e.preventDefault();
 
 var speech = new SpeechSynthesisUtterance();
 
 // Set the text and voice attributes.
 speech.text = document.getElementById("leer").value;
 speech.volume = 1;
 speech.rate = 1;
 speech.pitch = 1;
 speech.lang = "es";
 window.speechSynthesis.speak(speech);
 
 });**/
        </script>        
    </head>
    <body>
        <!--Prueba de cambiando imagenes
        <input id="ancho" type="number" min="0" value="200" onchange="cambiarTam()">
        <input id="alto" type="number" min="0" value="200" onchange="cambiarTam()">
        <div>
            <img id="img1" src="Imagenes/victor.jpg" alt="Victor">
        </div>


        <form method=GET action="http://www.arasaac.org/buscar.php?s=casa&idiomasearch=0&Buscar=Buscar&buscar_por=1&pictogramas_color=1">
            <table bgcolor="#FFFFFF">
                <tr>
                    <td>
                        <input TYPE=text name=s size=31 maxlength=255 value="">
                        <input type="hidden" name="idiomasearch" value="0">
                        <input type=submit name=Buscar VALUE="Buscar">
                        <input type="hidden" name="buscar_por" value="1">
                        <input type="hidden" name="pictogramas_color" value="1">
                    </td>
                </tr>
            </table>
        </form>

        <hr>

        <FORM method=GET action="http://www.google.com/search"> 
            <input type=hidden name=ie value=UTF-8> 
            <input type=hidden name=oe value=UTF-8> 
            <TABLE bgcolor="#FFFFFF"> 
                <tr>
                    <td> 
                        <A HREF="http://www.google.com/"> 
                            <IMG SRC="" 
                                 border="0" ALT="Google"></A> 
                    </td>
                    <td> 
                        <INPUT TYPE=text name=q size=31 maxlength=255 value=""> 
                        <INPUT type=submit name=btnG VALUE="Buscar en sitio"> 
                        <font size=-1> 
                        <br>
                        <input type=radio name=sitesearch value="" checked>WWW (toda la web)<br>
                        <input type=hidden name=domains value="http://www.elpais.com" />
                        <input type=radio name=sitesearch value="http://www.elpais.com"> Buscar en EL PAÍS<br> 
                        <input type=hidden name=domains value="http://www.elmundo.es" />
                        <input type=radio name=sitesearch value="http://www.elmundo.es"> Buscar en EL MUNDO<br> 
                        <input type=hidden name=domains value="http://www.publico.es" />
                        <input type=radio name=sitesearch value="http://www.publico.es"> Buscar en PÚBLICO<br> 
                        <input type=hidden name=domains value="http://www.abc.es" />
                        <input type=radio name=sitesearch value="http://www.abc.es"> Buscar en ABC<br> 
                        </font> 
                    </td>
                </tr>
            </TABLE> 
        </FORM>
        -->
        <div>
            <form id="form" action="oliii" method="post" onclick="hablar()">
                {{csrf_field()}}
                <button type="submit"><img id="img1" src="Imagenes/victor.jpg" alt="Victor" style="width: 200px"></button>                             
                <input id="leer" type="hidden" value="Victor">
            </form>
        </div>

    </body>
</html>
