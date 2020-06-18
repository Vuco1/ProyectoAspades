<!DOCTYPE html>
<html lang="<?php echo \App::getLocale()?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">  
        <title>@yield('titulo')</title>
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('files/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">
        <!--link rel="stylesheet" href="{{ asset('css/general-styles.css') }}"-->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
        <?php
        if (session()->has('lang')) {
            $lang = session()->get('lang');
            if (strcmp($lang, "es")=== 0) {
                ?>
                <script src="{{ asset('js/ajax.js') }}"></script>
                <script src="{{ asset('js/scripts.js') }}"></script>
                <?php
            } else {
                ?>
                <script src="{{ asset('js/ajax_en.js') }}"></script>
                <script src="{{ asset('js/scripts_en.js') }}"></script>
                <?php
            }
        } else {
            ?>
            <script src="{{ asset('js/ajax.js') }}"></script>
            <script src="{{ asset('js/scripts.js') }}"></script>
            <?php
        }
        ?>
        
    </head>
    <body class="<?php if (session()->has('temas')) { $tema = session()->get('temas'); echo "theme-".$tema->Tema; } else { echo "theme-default"; }?>">
        <div id="contenido">@yield('contenido')</div>
        <!-- SCRIPTS -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS --> 
        <script src="{{ asset('files/bootstrap-4.3.1-dist/js/bootstrap.popper.min.js') }}"></script>
        <script src="{{ asset('files/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/686f2338a1.js" crossorigin="anonymous"></script>
    </body>
</html>
