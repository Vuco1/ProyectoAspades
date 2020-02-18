@extends('plantillas/maestra')
@section('titulo')
SubContextos
@endsection
<link rel="stylesheet" href="{{ asset('css/grid_tableros.css') }}">
@section('contenido')
<!-- HEADER -->
<header id="menuoculto" class="d-none">
    <nav id="menu" class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="iniciousuario"><img src="{{ asset('images/icons/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#divnav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="divnav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="iniciousuario"><i class="fas fa-home icono"></i>Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-user-circle icono"></i>Perfil</a></li>
                <li class="nav-item"><button class="nav-link border-0 bg-transparent" data-toggle="modal" data-target="#nuevo"><i class="fas fa-plus-square icono"></i>Añadir Tablero</button></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-pen-square icono"></i>Modificar actual</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-minus-square icono"></i>Eliminar actual</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="d-flex">
    <div id="carouselSubcontextos" class="carousel slide w-100" data-ride="carousel" data-interval="false" data-touch="true">
        <div class="carousel-inner">
            <?php if (!$subcontextos) { ?>
                <h1>Sin Resultados</h1><?php
        } else {
            $cont = 0;
            $limite = 6;
            foreach ($subcontextos as $imgT) {
                if ($cont % $limite == 0) {
                    if ($cont == 0) {
                        echo '<div class="carousel-item '. $imgT->Dimension .' active">';
                    } else {
                        echo '<div class="carousel-item'. $imgT->Dimension .'">';
                    }
                } ?>
            <div class="card">
                <form id="form<?php echo $cont?>" name="formtablero" action="obtenersubcontextos" method="post" class="m-0">
                    @csrf
                    <input type="hidden" name="puntero" value="{{ $imgT->Id_imagen }}">
                    <button class="btn p-0 w-100">
                        <img src="{{ $imgT->Ruta }}" alt="Imagen del contexto" class="card-img-top img-subcontexto" style="height: calc((100vh / {{ $imgT->Total_filas }}) - 2.75rem)">
                        <div class="card-body p-2">
                            <p id="leer<?php echo $cont?>" class="card-text">{{ $imgT->Nombre }}</p>
                        </div>
                    </button>                
                </form>
                <div class="card-footer d-none">
                    <div class="row px-2">
                        <button type="submit" name="modificarcontexto" id="modificar{{ $imgT->Id_imagen }}" class="btn btn-success col mr-md-3"><img src="{{ asset('images/icons/check-solid.svg') }}" class="icono-crud"/><span class="d-none d-md-inline">Editar</span></button>
                        <button type="submit" name="eliminarcontexto" id="eliminar{{ $imgT->Id_imagen }}" class="btn btn-danger col"><img src="{{ asset('images/icons/times-solid.svg') }}" class="icono-crud"/><span class="d-none d-md-inline">Borrar</span></button>
                    </div>
                </div>
            </div>
                <?php if (($cont + 1) % $limite == 0) {
                        echo '</div>';
                    }
                    $cont++;
                }
            }
            ?>
        </div>
    </div>
</main>
@include('plantillas/footer')
@endsection
