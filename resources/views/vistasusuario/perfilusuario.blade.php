@extends('plantillas/maestra')
@section('titulo')
@lang('messages.TituloPerfil')
@endsection
@section('contenido')
<!-- HEADER -->
<header id="menuoculto" class="d-none">
    <nav id="menu" class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="iniciousuario"><img src="{{ asset('images/icons/logo_aspades.svg') }}" alt="Logo" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#divnav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="divnav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="iniciousuario"><i class="fas fa-home icono"></i>@lang('messages.NavInicio')</a></li>
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-user-circle icono"></i>@lang('messages.NavPerfil')</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_perf_usu"><i class="fas fa-question-circle icono"></i>@lang('messages.NavAyuda')</a></li>
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
        <h2>@lang('messages.PerfilUsuario')</h2>
        <button class="btn btn-orange rounded-circle p-3 mb-4"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
    </div>
    <form action="editarperfilusuario" method="post" class="col-md-6 m-auto" enctype="multipart/form-data">
        @csrf
        <input type="text" name="id" value="<?= $usuario->Id_usuario ?>" hidden>              
        <div class="form-group">
            <label class="sr-only" for="usuario">Usuario</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>@lang('messages.PerfilUsuUsuario')</div>
                </div>
                <input type="text" name="usuario" id="usuario" value="<?= $usuario->Nick ?>" placeholder="@lang('messages.PerfilUsuUsuario')" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="nombre">Nombre</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>@lang('messages.PerfilUsuNombre')</div>
                </div>
                <input type="text" name="nombre" id="nombre" value="<?= $usuario->Nombre ?>" placeholder="@lang('messages.PerfilUsuNombre')" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span id="descripcionimagen" class="input-group-text w-8"><i class="fas fa-image icono"></i>@lang('messages.PerfilUsuImagen')</span>
                </div>
                <div class="custom-file">
                    <?php 
                        $lang = session()->get('lang');
                        if ( $lang == 'en' ){ ?>
                        <input type="file" name="image" id="image" aria-describedby="descripcionimagen" onchange="cambiarTexto(this.id)">
                    <?php } else { ?>
                        <input type="file" name="image" id="image" class="custom-file-input" aria-describedby="descripcionimagen" onchange="cambiarTexto(this.id)"> 
                    <?php }?>
                    <label id="imagenlabel" for="imagen" class="custom-file-label">@lang('messages.PerfilUsuImagenPH')</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="claveperfil">Contraseña</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>@lang('messages.PerfilUsuClave')</div>
                </div>
                <input type="password" name="clave" id="claveperfil" placeholder="@lang('messages.PerfilUsuClavePH')" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="claverepeperfil">Confirmar</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8"><i class="fas fa-check-double icono"></i>@lang('messages.PerfilUsuConfirmar')</div>
                </div>
                <input type="password" name="claverep" id="claverepeperfil" placeholder="@lang('messages.PerfilUsuConfirmarPH')" class="form-control" onkeyup="validarClave('perfil')">
            </div>
        </div>
        <div id="mensajeperfil" class="text-center my-3 text-success"><?php if (isset($mensaje)) { echo $mensaje; } ?></div>
        <input type="submit" name="guardar" id="guardar" value="@lang('messages.PerfilUsuGuardarCambios')" class="btn btn-orange w-100">
    </form>
<?php } ?>
    
    <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_perf_usu">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange text-white px-4">
                <div class="modal-title">@lang('messages.ModalAyuda')</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-justify">
                <ul>
                    <li><p>@lang('messages.ModalPerfilAdminAyudaP1')</p></li>
                    <li><p>@lang('messages.ModalPerfilAdminAyudaP2')</p></li>
                    <li><p>@lang('messages.ModalPerfilAdminAyudaP3')</p></li>
                    <li><p>@lang('messages.ModalPerfilAdminAyudaP4')</p></li>
                </ul>
            </div>
        </div>
    </div>
</section>
    
</main>
@include('plantillas/footer')
@endsection

