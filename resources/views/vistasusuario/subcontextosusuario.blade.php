@extends('plantillas/maestra')
@section('titulo')
SubContextos
@endsection
@section('contenido')
<!-- HEADER -->
<header id="menuoculto" style="display: none">
    <nav id="menuoculto" class="navbar navbar-expand-md navbar-light bg-light p-0" style="display: none;">
        <a class="py-2 px-3" href="iniciousuario"><img src="{{ asset('images/icons/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><div>
                        <button data-toggle="modal" data-target="#nuevo" class="btn btn-orange">Añadir Imagen</button>
                    </div></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users-cog icono"></i>Eliminar</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users-cog icono"></i>Modificar</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="d-flex pt-3">
    <div id="carouselSubcontextos" class="carousel slide m-auto px-5" data-ride="carousel" data-interval="false" data-touch="true">
        <div class="carousel-inner">
            <?php if (!$subcontextos) { ?>
                <h1>Sin Resultados</h1><?php
        } else {
            $cont = 0;
            $limite = 6;
            foreach ($subcontextos as $imgT) {
                if ($cont % $limite == 0) {
                    if ($cont == 0) {
                        echo '<div class="carousel-item active">';
                    } else {
                        echo '<div class="carousel-item">';
                    }
                } ?>
            <div class="card">
                <form action="obtenersubcontextos" method="post">
                    @csrf
                    <input type="hidden" name="puntero" value="{{ $imgT->Id_imagen }}">
                    <button class="btn p-0 w-100">
                        <img src="{{ $imgT->Ruta }}" class="card-img-top img-contexto" alt="Imagen del contexto">
                        <div class="card-body p-2">
                            <p class="card-text">{{ $imgT->Nombre }}</p>
                        </div>
                    </button>                
                </form>
                <div class="card-footer">
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
@endsection

