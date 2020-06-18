@extends('plantillas/maestra')
@section('titulo')
@lang('messages.PersonalizarAdminTitulo')
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
                <li class="nav-item"><a class="nav-link" href="inicioadmin"><i class="fas fa-home icono"></i>@lang('messages.NavInicio')</a></li>
                <li class="nav-item"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>@lang('messages.NavGestion')</a></li>
                <li class="nav-item"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>@lang('messages.NavPerfil')</a></li>
                <li class="nav-item active"><a class="nav-link" href="personalizar"><i class="fas fa-user-cog icono"></i>@lang('messages.NavPersonalizar')</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_perf_admin"><i class="fas fa-question-circle icono"></i>@lang('messages.NavAyuda')</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="pt-5">
    <div class="text-center">
        <h2>@lang('messages.PersonalizarAdminTitulo')</h2>
        <img class="logo-nav p-3 mb-4" src="<?php $tema = session()->get('temas'); echo $tema->Logo;  ?>"/>
    </div>
    <form action="personalizarweb" method="post" class="col-md-6 m-auto" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span id="descripcionimagen" class="input-group-text w-8"><i class="fas fa-image icono"></i>@lang('messages.PersonalizarLogo')</span>
                </div>
                <div class="custom-file">
                    <input name="imagenlogo" id="imagenlogo" type="file" class="custom-file-input" aria-describedby="descripcionimagen" onchange="cambiarTexto(this.id)">
                    <label id="imagenlabel" for="imagen" class="custom-file-label">@lang('messages.PersonalizarLogoPH')</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only">@lang('messages.PersonalizarColor')</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text w-8">@lang('messages.PersonalizarColor')</div>
                </div>
                <select name="color" id="color">
                    <option value="blue">@lang('messages.PersonalizarColor1')</option>
                    <option value="green">@lang('messages.PersonalizarColor2')</option>
                    <option value="red">@lang('messages.PersonalizarColor3')</option>
                </select>
            </div>
        </div>
        <input type="submit" name="guardar" id="guardarpersonalizacion" value="@lang('messages.PersonalizarEditarBoton')" class="btn btn-color w-100">
    </form>

    <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_perf_admin">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-color text-white px-4">
                    <div class="modal-title">@lang('messages.ModalAyuda')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4 text-justify">
                    <ul>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

</main>
@include('plantillas/footer')
@endsection
