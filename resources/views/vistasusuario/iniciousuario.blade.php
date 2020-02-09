<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->

    </head>
    <body>
        <?php $fotoPerfil = session()->get('imgperfil'); ?>        
        <form action="iniciarContexto" method="post">
            @csrf
            <button><img src="<?php echo $fotoPerfil->Ruta?>" width="500" height="500"/></button>
        </form>
        
        <form action="cambiarFoto" method="post">
            @csrf
            <button>Cambiar foto de perfil</button>
        </form>
        <div id="mensaje" class="mt-3"><?php if (isset($mensaje)) { echo $mensaje; } ?></div>
        <!-- SCRIPTS -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
    </body>
</html>