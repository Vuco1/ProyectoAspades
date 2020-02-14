@extends('plantillas/maestra')
@section('titulo')
Perfil
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
<main>
    <?php
    if (session()->has('usuario')) {
        $usuario = session()->get('usuario');
        ?>
    <button class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        <h2>Mi perfil</h2>
        <form action="editarperfil" method="post" class="col-xl-4 col-lg-5 col-md-6 m-auto" enctype="multipart/form-data">
            @csrf
            <input type="text" name="id" value="<?= $usuario->Id_usuario ?>" hidden>              
            <div class="form-group">
                <label class="sr-only" for="usuario">Usuario</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Usuario</div>
                    </div>
                    <input type="text" name="usuario" id="usuario" value="<?= $usuario->Nick ?>" placeholder="Usuario" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="nombre">Nombre</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Nombre</div>
                    </div>
                    <input type="text" name="nombre" id="nombre" value="<?= $usuario->Nombre ?>" placeholder="Nombre" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="imagen">Imagen</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text w-8"><i class="fas fa-image icono"></i>Imagen</div>
                    </div>
                    <input id="imagen" name="imagen" type="file" class="form-control-file"/>
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="clave">Contraseña</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text w-8"><i class="fas fa-key icono"></i>Contraseña</div>
                    </div>
                    <input type="password" name="clave" id="clave" placeholder="Escriba su nueva contraseña" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="claverepe">Confirmar</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text w-8"><i class="fas fa-copy icono"></i>Confirmar</div>
                    </div>
                    <input type="password" name="claverep" id="claverepe" placeholder="Repita la contraseña" class="form-control">
                </div>
            </div>
            <input type="submit" name="guardar" id="guardar" value="Guardar cambios" class="btn btn-orange w-100">
        </form>
        <div id="mensaje" class="mt-3"><?php
            if (isset($mensaje)) {
                echo $mensaje;
            }
            ?></div>
<?php } ?>
</main>
@include('plantillas/footer')
@endsection

