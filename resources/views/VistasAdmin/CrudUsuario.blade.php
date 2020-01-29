<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <?php foreach ($datos as $dato) { ?>
            <form action="crudUsu" method="post">
                @csrf
                <input type="text" name="Nick"  value="<?php echo $dato['nick'] ?>" >
                <input type="text" name="Nombre" value="<?php echo $dato['nombre'] ?>" >
                <input type="checkbox" name="Rol" <?php if ($dato['rol'] === 1) { ?>checked<?php } ?> value="">
                    <input type="submit" name="eliminarUsuario" value="Eliminar">
                    <input type="submit" name="modificarCoche" value="Modificar"><br/>
                </form>
                <?php
            }
        ?>
    </body>
</html>
