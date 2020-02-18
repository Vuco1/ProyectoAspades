@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
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
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>

<!-- MAIN -->
<main class="d-flex pt-3">
    <?php $usuario = session()->get('usuario'); ?>        
    <form id="form0" name="formtablero" action="obtenercontextos" method="post" class="m-auto">
        @csrf
        <button class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        <h1 id="leer0">Hola <?php echo $usuario->Nick ?></h1>
        <input  type="hidden" value="Hola <?php echo $usuario->Nick ?>">
    </form>
    <div id="mensaje" class="mt-3"><?php
        if (isset($mensaje)) {
            echo $mensaje;
        }
        ?>
    </div>
    <!-- SCRIPTS -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
</main>
@include('plantillas/footer')
@endsection
