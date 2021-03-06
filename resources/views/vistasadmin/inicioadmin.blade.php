@extends('plantillas/maestra')
@section('titulo')
@lang('messages.InicioAdminTitulo')
@endsection
@section('contenido')
        <!-- HEADER -->
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
                <a class="py-2 px-3" href="inicioadmin"><img id="logo" src="" alt="Logo" class="logo-nav"/></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active"><a class="nav-link" href="inicioadmin"><i class="fas fa-home icono"></i>@lang('messages.NavInicio')</a></li>
                        <li class="nav-item"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>@lang('messages.NavGestion')</a></li>
                        <li class="nav-item"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>@lang('messages.NavPerfil')</a></li>
                        <li class="nav-item"><a class="nav-link" href="personalizar"><i class="fas fa-user-cog icono"></i>@lang('messages.NavPersonalizar')</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_ini_adm"><i class="fas fa-question-circle icono"></i>@lang('messages.NavAyuda')</a></li>
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
                <a href="gestionusuarios" class="btn btn-color rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></a>
                <h1>@lang('messages.SaludoAdmin') <?php echo $usuario->Nick ?></h1>  
            </div>
            <?php } ?>
            
            <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_ini_adm">
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
                    <li><p>@lang('messages.ModalInicioAyudaP1')</p></li>
                    <li><p>@lang('messages.ModalInicioAyudaP2')</p></li>
                    <li><p>@lang('messages.ModalInicioAyudaP3')</p></li>
                    <li><p>@lang('messages.ModalInicioAyudaP4')</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
            
        </main>
@include('plantillas/footer')
@endsection

