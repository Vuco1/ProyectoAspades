@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')

<!-- HEADER -->
<header id="menuoculto" style="display: none">
    <nav id="menu" class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="iniciousuario"><img src="{{ asset('images/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-user-circle icono"></i>Perfil</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>

<!-- MAIN -->
<main class="d-flex pt-3">
    <?php $usuario = session()->get('usuario'); ?>        
    <form action="obtenercontextos" method="post" class="m-auto">
        @csrf
        <button class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        <h1>Hola <?php echo $usuario->Nick ?></h1>
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
