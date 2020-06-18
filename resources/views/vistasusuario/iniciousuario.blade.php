@extends('plantillas/maestra')
@section('titulo')
@lang('messages.TituloInicio')
@endsection
@section('contenido')

<!-- HEADER -->
<header id="menuoculto" class="d-none">
    <nav id="menu" class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="iniciousuario"><img id="logo" src="" alt="Logo" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#divnav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="divnav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="iniciousuario"><i class="fas fa-home icono"></i>@lang('messages.NavInicio')</a></li>
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-user-circle icono"></i>@lang('messages.NavPerfil')</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_ini_usu"><i class="fas fa-question-circle icono"></i>@lang('messages.NavAyuda')</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>

<!-- MAIN -->
<main class="d-flex pt-3">
    <?php $usuario = session()->get('usuario'); ?>        
    <form id="form0" name="formtablero" action="obtenercontextos" method="post" class="m-auto text-center">
        @csrf
        <button name="btninicio" class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        <h1 id="leer0">@lang('messages.SaludoAdmin') <?php echo $usuario->Nick ?></h1>
    </form>
    <div id="mensaje" class="mt-3"><?php
        if (isset($mensaje)) {
            echo $mensaje;
        }
        ?>
    </div> 
    
<!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_ini_usu">
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
                    <li><p>@lang('messages.ModalInicioAyudaUsuP1')</p></li>
                    <li><p>@lang('messages.ModalInicioAyudaUsuP2')</p></li>
                    <li><p>@lang('messages.ModalInicioAyudaUsuP3')</p></li>
                    <li><p>@lang('messages.ModalInicioAyudaUsuP4')</p></li>
                </ul>
            </div>
        </div>
    </div>
</section>
    
</main>
@include('plantillas/footer')
@endsection
