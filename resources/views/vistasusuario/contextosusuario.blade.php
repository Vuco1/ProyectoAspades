<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->

    </head>
    <body>
        <?php foreach ($imgtab as $imgT) { ?>
            <form action="contextosUsuario" method="post">
                @csrf
                <input type="hidden" name="id" value="<?= $imgT->Id_imagen ?>">
                <button><img src="<?php echo $imgT->Ruta ?>" width="500" height="500"/></button>
                <input type="text" name="contexto" value="<?= $imgT->Nombre ?>">
            </form>
        <?php } ?>        

        <!-- SCRIPTS -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
    </body>
</html>
