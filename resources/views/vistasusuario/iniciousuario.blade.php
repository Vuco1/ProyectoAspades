@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
<!-- HEADER -->
<header>
    <nav id="menuoculto" class="navbar navbar-expand-md navbar-light bg-light p-0" style="display: none;">
        <a class="py-2 px-3" href="iniciousuario"><img src="{{ asset('images/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-users-cog icono"></i>Modificar perfil usuario</a></li>
            </ul>
        </div>
    </nav>
    <input type="button" value="Ocultar" id="c1">
    <input type="button" value="Visualizar" id="c2">
</header>
<!-- MAIN -->
<main class="d-flex pt-3">
    <?php $usuario = session()->get('usuario'); ?>        
    <form id="form0" name="formtablero" action="obtenercontextos" method="post" class="m-auto">
        @csrf
        <button class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        <h1>Hola <?php echo $usuario->Nick ?></h1>
        <input id="leer0"type="hidden" value="<?php echo $usuario->Nick ?>">
    </form>
    <div id="mensaje" class="mt-3"><?php
        if (isset($mensaje)) {
            echo $mensaje;
        }
        ?></div>
    <!-- SCRIPTS -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
</main>
@include('plantillas/footer')
@endsection
