<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
        <title>@yield('titulo')</title>
    </head>
    <body>
        @include('plantillas/header')
        @if (Session::has ('usuario'))
        <?php $usuario = Session::get ('usuario') ?>
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
