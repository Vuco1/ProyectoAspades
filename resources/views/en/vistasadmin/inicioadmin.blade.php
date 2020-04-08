@extends('en/plantillas/maestra')
@section('titulo')
Welcome page
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
                        <li class="nav-item active"><a class="nav-link" href="inicioadmin"><i class="fas fa-home icono"></i>Welcome page</a></li>
                        <li class="nav-item"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>Users management</a></li>
                        <li class="nav-item"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>My profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_ini_adm"><i class="fas fa-question-circle icono"></i>Help</a></li>
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
                <h1>Hello <?php echo $usuario->Nick ?></h1>  
            </div>
            <?php } ?>
            
            <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_ini_adm">
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
                    <li><p>If we click on <span><img src="../public/images/icons/Screenshot_20200305_122931.png" width="30px"></span> or <span class="text-secondary px-1"><i class="fas fa-users-cog icono"></i>Users management</span>, we will see a list of all registered users.</p></li>
                    <li><p>If we click on <span class="text-secondary px-1"><i class="fas fa-user-circle icono"></i>My profile</span>, we will be able to modify our own profile data.</p></li>
                    <li><p>If we click on <span class="text-secondary px-1"><i class="fas fa-home icono"></i>Welcome page</span> or on the logo, we will come back to the welcome page.</p></li>
                    <li><p>If we click on <span class="text-secondary pl-1"><i class="fas fa-power-off icono"></i></span>, we will log out the web and we will need to log in if we want to access again.</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
            
        </main>
@include('en/plantillas/footer')
@endsection

