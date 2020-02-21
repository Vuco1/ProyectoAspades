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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th icono"></i>Administrar tablero</a>
                    <div class="dropdown-menu w-100" aria-labelledby="navbarDropdown">
                        <button class="dropdown-item" data-toggle="modal" data-target="#nuevo"><i class="fas fa-plus-square icono"></i>Añadir Tablero</button>
                        <a class="dropdown-item" href="#"><i class="fas fa-pen-square icono"></i>Modificar actual</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-minus-square icono"></i>Eliminar actual</a>
                    </div>
                </li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="d-flex">
    <div id="carouselSubcontextos" class="carousel slide w-100" data-ride="carousel" data-interval="false" data-touch="true">
        <?php if (isset($paginas)) {?>
        <ol class="carousel-indicators">
            <?php 
            for ($i = 0; $i < $paginas; $i++) {
                if ($i == 0) {
                    echo '<li data-target="#carouselSubcontextos" data-slide-to="0" class="active"></li>';
                } else {
                    echo '<li data-target="#carouselSubcontextos" data-slide-to="'. $i .'"></li>';
                }
            } ?>
        </ol>
        <?php } ?>
        <div class="carousel-inner h-100 d-flex">
            <?php if (!$subcontextos) { ?>
            <h1 class="m-auto">Sin Resultados</h1><?php
        } else {
            $cont = 0;
            $pagActual = 1;
            for ($i = 1; $i <= $casTotal; $i++) {
                if ($cont % $casPorPag == 0) {
                    if ($cont == 0) {
                        echo '<div class="carousel-item active">';
                    } else {
                        echo '<div class="carousel-item">';
                    }
                    echo '<div class="'. $dimension .'">';
                }
                ?>
            <div class="card">
                <form id="form<?php echo $i?>" name="formtablero" action="obtenersubcontextos" method="post" class="m-0">
                    @csrf
                    <input type="hidden" name="anterior" value="{{ $subcontextos[$i]->Puntero }}">
                    <input type="hidden" name="actual" value="{{ $subcontextos[$i]->Id_tablero }}">
                    <input type="hidden" name="numfilas" value="{{ $subcontextos[$i]->Filas }}">
                    <input type="hidden" name="accion" value="0">
                    <button class="btn p-0 w-100">
                        <img src="{{ $subcontextos[$i]->Imagen }}" alt="Imagen del contexto" class="card-img-top img-subcontexto" style="height: calc((100vh / {{ $subcontextos[$i]->Filas }}) - 2.75rem)">
                        <div class="card-body p-2">
                            <p id="leer<?php echo $i?>" class="card-text">{{ $subcontextos[$i]->Nombre }}</p>
                        </div>
                    </button>                
                </form>
                <?php if ($dimension == "grid-lg" && (3 * $pagActual - 1) == $i) { ?>
                <div></div>
                <?php } else { ?>            
                <div class="card-footer d-none">
                    <div class="row px-2">
                <?php if ($subcontextos[$i]->Imagen != "images/tabs/blanco.jpg") { ?>
                        <button data-toggle="modal" data-target="#modificar" onclick="modificarContexto({{ $subcontextos[$i]->Id_tablero }})" type="submit" name="modificarcontexto" id="modificar{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-info col mr-md-3"><img src="{{ asset('images/icons/pen-solid.svg') }}" class="icono-crud"/><span class="d-none d-md-inline">Editar</span></button>
                        <button data-toggle="modal" data-target="#eliminar" onclick="eliminarContexto({{ $subcontextos[$i]->Id_tablero }})" type="submit" name="eliminarcontexto" id="eliminar{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-danger col"><img src="{{ asset('images/icons/minus-solid.svg') }}" class="icono-crud"/><span class="d-none d-md-inline">Borrar</span></button>
                <?php } else { ?>
                        <button data-toggle="modal" data-target="#nuevo" onclick="addContexto({{ $i }})" type="submit" name="nuevocontexto" id="nuevo{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-success col"><img src="{{ asset('images/icons/plus-solid.svg') }}" class="icono-crud"/><span class="d-none d-md-inline">Añadir</span></button>
                <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php
                if (($cont + 1) % $casPorPag == 0) {
                    echo '</div></div>';
                }
                $cont++;
                if ($cont == $casPorPag + 1) {
                    $cont = 1;
                    $pagActual++;
                }
            }
        } ?>
        </div>
    </div>
    <!-- VENTANA MODAL MODIFICAR SUBCONTEXTO -->
    <section class="modal fade" id="modificar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Modificar Subcontexto</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <img id="imgcontexto" src="" class="img-perfil" alt="Imagen del contexto">
                    <form action="modificarTablero" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="sr-only" for="Foto">Foto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Foto</div>
                                </div>
                                <input type="file" name="image" id="imagecontexto" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Nombre</div>
                                </div>
                                <input type="hidden" id="idimg" name="id_imagen" value="">
                                <input type="hidden" id="idtablero" name="id_tablero" value="">
                                <input type="text" name="nombre" id="nombrecontexto"  placeholder="Nombre" class="form-control">
                            </div>
                        </div> 
                        <input type="submit" name="guardar" id="guardar" value="Añadir" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- VENTANA MODAL ELIMINAR -->
    <section class="modal fade" id="eliminar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Eliminar Subcontexto</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarTablero" method="post" enctype="multipart/form-data">
                        @csrf
                        <p>Estas seguro de que deseas elimar este subcontexto </p>
                        <input type="hidden" name="idelim" id="idelim" value="">
                        <input type="submit" name="delete" id="delete" value="eliminar" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@include('plantillas/footer')
@endsection
