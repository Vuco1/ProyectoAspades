<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

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
            function isValid() {
                var string1 = document.getElementById('clave1').value;
                var string2 = document.getElementById('clave2').value;
                if (this.value === string2) {
                    if (string1 === string2) {
                        document.getElementById("validar").disabled = false;
                    } else {
                        alert('Las claves son diferentes');
                    }
                } else {
                    if (string1 === string2) {
                        document.getElementById("validar").disabled = false;
                    } else {
                        document.getElementById("validar").disabled = true;
                    }
                }

            }
        </script>
    </head>
    <body>
        <form action="registrar" method="post">
            @csrf
            <input type="text" name="usuario" placeholder="Nombre del Usuario">
            <input id="clave1" type="password" name="clave" placeholder="Clave" onblur="isValid()">
            <input id="clave2" type="password" name="clave2" placeholder="Repite la Clave" onblur="isValid()">
            <label for="rol">¿Ser Administrador?</label>  
            <input id="rol" type="checkbox" name="rol" value="Admin">
            <input id="validar" type="submit" value="Registrar" disabled>
        </form>
    </body>
</html>
