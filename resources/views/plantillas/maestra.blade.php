<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <title>@yield('titulo')</title>
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('files/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    </head>
    <body>
        <div id="contenido">@yield('contenido')</div>
        <!-- SCRIPTS -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="{{ asset('files/bootstrap-4.3.1-dist/js/bootstrap.jquery-3.4.1.slim.min.js') }}"></script>
        <script src="{{ asset('files/bootstrap-4.3.1-dist/js/bootstrap.popper.min.js') }}"></script>
        <script src="{{ asset('files/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/686f2338a1.js" crossorigin="anonymous"></script>        
        <script src="{{ asset('js/ajax.js') }}"></script>
    </body>
</html>