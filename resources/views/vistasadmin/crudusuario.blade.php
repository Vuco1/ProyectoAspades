<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Laravel</title>
        <script src="js/jquery-3.4.1.min.js"></script>
        
        <script src="js/ajax.js"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <?php foreach ($datos as $dato) { ?>
        <form id="form" name='form' class='form'>
                @csrf
                <input type="hidden" class="id" name="Id" id="id<?php echo $dato->Id_usuario ?>"  value="<?php echo $dato->Id_usuario ?>" >
                <input type="text" name="Nick"  id="nick<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nick ?>" >
                <input type="text" name="Nombre" id="nombre<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nombre ?>" >
                <select name="Rol" id="rol<?php echo $dato->Id_usuario ?>" class="form-control">
                    <?php foreach ($datos2 as $da2) { ?>
                        <option name="" value="<?php echo $da2->Id_rol?>"<?php if ($dato->Id_rol ==$da2->Id_rol) { ?>selected<?php } ?>><?php echo $da2->Descripcion?></option>
                        <?php
                    }
                    ?>
                </select>
                <button id="eliminar<?php echo $dato->Id_usuario ?>" class="formbutton" name="eliminar">Eliminar</button>
                <button id='modificar<?php echo $dato->Id_usuario ?>' class="formbutton" name="modificar">Modificar</button><br/>
        </form>
            <?php
        }
        ?>
        <a href="addUsuario">add</a>
        {{ $datos->links() }}
    </body>
</html>
