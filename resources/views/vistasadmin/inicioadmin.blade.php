<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Página de inicio de administrador</title>
    </head>
    <body>
        @include('plantillas/header')
        @if (\Session::has ('usuario'))
        <!--{!! $usuario = \Session::get('usuario') !!}-->
        <h1>Hola <?php echo $usuario->Nick ?></h1>

        @endif
    </body>
</html>
