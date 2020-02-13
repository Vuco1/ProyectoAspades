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
    <form action="obtenercontextos" method="post" class="m-auto">
        @csrf
        <button class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        <h1>Hola <?php echo $usuario->Nick ?></h1>
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
<a class="py-2 px-3 text-secondary float-left" data-toggle="modal" data-target="#login"><i class="fas fa-info-circle h2 m-0"></i></a>

<!-- VENTANA MODAL LOGIN -->
<section class="modal fade" id="login">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange text-white px-4">
                <div class="modal-title">Información</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="comprobar" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="sr-only" for="clave">Contraseña</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input type="password" name="clave" id="clave" placeholder="Contraseña" class="form-control">
                        </div>
                    </div>
                    <input type="submit" name="login" id="login" value="Iniciar sesión" class="btn btn-orange w-100">
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
