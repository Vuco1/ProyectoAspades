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
    </head>
    <body>
        @if (Session::has ('usuario'))
        $usuario = Session::get ('usuario')
        <h1>Mi perfil</h1>
        <form action="editar_perfil" method="post">
            @csrf
            <input type="text" name="id" value="<?= $usuario->Id_usuario?>">
            <input type="text" name="nick" value="<?= $usuario->Nick?>">
            <input type="text" name="nombre" value="<?= $usuario->Nombre?>">
            <input type="text" name="clave" placeholder="Escriba su nueva contraseña">
            <input type="submit" value="Guardar cambios">
        </form>
        
        <div>
            <?php $mensaje ?>
        </div>
        @endif
    </body>
</html>
