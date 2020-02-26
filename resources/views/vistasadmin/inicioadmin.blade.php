@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
        <!-- HEADER -->
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
                <a class="py-2 px-3" href="inicioadmin"><img src="{{ asset('images/icons/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active"><a class="nav-link" href="inicioadmin"><i class="fas fa-home icono"></i>Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>Gestión</a></li>
                        <li class="nav-item"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>Perfil</a></li>
                    </ul>
                    <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
                </div>
            </nav>
        </header>
        <!-- MAIN -->
        <main class="d-flex pt-3">
            <?php if (session()->has('usuario')) {
            $usuario = session()->get('usuario'); ?>
            <div class="m-auto text-center">
                <a href="gestionusuarios" class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></a>
                <h1>Hola <?php echo $usuario->Nick ?></h1>  
            </div>
            <?php } ?>
        </main>
@include('plantillas/footer')
@endsection

