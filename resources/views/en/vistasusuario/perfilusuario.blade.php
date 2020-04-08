@extends('en/plantillas/maestra')
@section('titulo')
My profile
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
                <li class="nav-item"><a class="nav-link" href="iniciousuario"><i class="fas fa-home icono"></i>Welcome page</a></li>
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-user-circle icono"></i>My profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_perf_usu"><i class="fas fa-question-circle icono"></i>Help</a></li>
            </ul>
            <a class="text-secondary" href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="pt-5">
    <?php
    if (session()->has('usuario')) {
        $usuario = session()->get('usuario');?>
    <div class="text-center">
        <h2>My profile</h2>
        <button class="btn btn-orange rounded-circle p-3 mb-4"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
    </div>
    <form action="editarperfilusuario" method="post" class="col-md-6 m-auto" enctype="multipart/form-data">
        @csrf
        <input type="text" name="id" value="<?= $usuario->Id_usuario ?>" hidden>              
        <div class="form-group">
            <label class="sr-only" for="usuario">Nick name</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Nick name</div>
                </div>
                <input type="text" name="usuario" id="usuario" value="<?= $usuario->Nick ?>" placeholder="Nick name" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="nombre">Name</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Name</div>
                </div>
                <input type="text" name="nombre" id="nombre" value="<?= $usuario->Nombre ?>" placeholder="Name" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span id="descripcionimagen" class="input-group-text w-8"><i class="fas fa-image icono"></i>Picture</span>
                </div>
                <div class="custom-file">
                    <input name="imagen" id="imagen" type="file" class="custom-file-input" aria-describedby="descripcionimagen" onchange="cambiarTexto(this.id)">
                    <label id="imagenlabel" for="imagen" class="custom-file-label">Choose a new picture...</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="claveperfil">Password</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>Password</div>
                </div>
                <input type="password" name="clave" id="claveperfil" placeholder="Write a new password" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="claverepeperfil">Repeat</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-check-double icono"></i>Repeat</div>
                </div>
                <input type="password" name="claverep" id="claverepeperfil" placeholder="Repeat password" class="form-control" onkeyup="validarClave('perfil')">
            </div>
        </div>
        <div id="mensajeperfil" class="text-center my-3 text-success"><?php if (isset($mensaje)) { echo $mensaje; } ?></div>
        <input type="submit" name="guardar" id="guardar" value="Save changes" class="btn btn-orange w-100">
    </form>
<?php } ?>
    
    <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_perf_usu">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange text-white px-4">
                <div class="modal-title">Help</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-justify">
                <ul>
                    <li><p>Here we can modify our personal data.</p></li>
                    <li><p>We can change our nick name and name.</p></li>
                    <li><p>If we want to change our profile picture, we need to choose a new one.</p></li>
                    <li><p>If we want to change our password, we need to write it twice (in "password" and "repeat").
                The password will be change only if both times is the same.</p></li>
                </ul>
            </div>
        </div>
    </div>
</section>
    
</main>
@include('en/plantillas/footer')
@endsection

