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
                <input type="hidden" name="Id"  value="<?php echo $dato->Id_usuario ?>" >
                <input type="text" name="Nick"  value="<?php echo $dato->Nick ?>" >
                <input type="text" name="Nombre" value="<?php echo $dato->Nombre ?>" >
                <select name="Rol" id="Rol<?php echo $dato->Id_usuario ?>" class="form-control">
                    <?php foreach ($datos2 as $da2) { ?>
                        <option name="" value="<?php echo $da2->Id_rol?>"<?php if ($dato->Id_rol ==$da2->Id_rol) { ?>selected<?php } ?>><?php echo $da2->Descripcion?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="submit" name="eliminarUsuario" value="Eliminar">
                <input type="submit" name="modUsuario" value="Modificar"><br/>
            </form>
            <?php
        }
        ?>
        <a href="addUsuario">add</a>
        {{ $datos->links() }}
    </body>
</html>
