<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->

    </head>
    <body>
        Holi
        <form action="modificarFoto" method="post">
            @csrf
            <label for="imagen">Imagen </label> 
            <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
            <input id="imagen" name="imagen" size="30" type="file" class="form-control-file"/>
        </form>

        <!-- SCRIPTS -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
    </body>
</html>
