@extends('plantillas/maestra')
@section('titulo')
Perfil
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
                <li class="nav-item"><a class="nav-link" href="inicioadmin"><i class="fas fa-home icono"></i>Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>Gestión</a></li>
                <li class="nav-item active"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>Perfil</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_perf_admin"><i class="fas fa-question-circle icono"></i>Ayuda</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="pt-5">
    <?php if (session()->has('usuario')) {
        $usuario = session()->get('usuario');
        ?>
    <div class="text-center">
        <h2>Mi perfil</h2>
        <button class="btn btn-color rounded-circle p-3 mb-4"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
    </div>
    <form action="editarperfil" method="post" class="col-md-6 m-auto" enctype="multipart/form-data">
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
            <div class="input-group">
                <div class="input-group-prepend">
                    <span id="descripcionimagen" class="input-group-text w-8"><i class="fas fa-image icono"></i>Imagen</span>
                </div>
                <div class="custom-file">
                    <input name="imagen" id="imagen" type="file" class="custom-file-input" aria-describedby="descripcionimagen" onchange="cambiarTexto(this.id)">
                    <label id="imagenlabel" for="imagen" class="custom-file-label">Selecciona tu nueva imagen...</label>
                </div>
            </div>
        </div>           
        <div class="form-group">
            <label class="sr-only" for="claveperfil">Contraseña</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>Contraseña</div>
                </div>
                <input type="password" name="clave" id="claveperfil" placeholder="Escribe tu nueva contraseña" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="claverepeperfil">Confirmar</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-check-double icono"></i>Confirmar</div>
                </div>
                <input type="password" name="claverepe" id="claverepeperfil" placeholder="Repite la nueva contraseña" class="form-control" onkeyup="validarClave('perfil')">
            </div>
        </div>
        <div id="mensajeperfil" class="text-center my-3 text-success"><?php if (isset($mensaje)) { echo $mensaje; } ?></div>
        <input type="submit" name="guardar" id="guardarperfil" value="Guardar cambios" class="btn btn-color w-100">
    </form>
<?php } ?>
    
        <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_perf_admin">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-color text-white px-4">
                <div class="modal-title">Ayuda</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-justify">
                <ul>
                    <li><p>Aquí podemos modificar nuestros datos personales.</p></li>
                    <li><p>Podemos cambiar nuestro nombre y nuestro nombre de usuario.</p></li>
                    <li><p>Si queremos cambiar nuestra foto de perfil, debemos elegir una nueva.</p></li>
                    <li><p>Si queremos poner una contraseña nueva, tenemos que escribirla en los dos campos que nos la piden.
                La contraseña sólo se cambiará si coincide en estos dos campos.</p></li>
                </ul>
            </div>
        </div>
    </div>
</section>
    
</main>
@include('plantillas/footer')
@endsection
