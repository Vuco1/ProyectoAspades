@extends('plantillas/maestra')
@section('titulo')
ContextosGenerales
@endsection
@section('contenido')
<main class="container-fluid">
<nav id="menuoculto" class="navbar navbar-expand-md navbar-light bg-light p-0" style="display: none;">
        <a class="py-2 px-3" href="inicioadmin"><img src="{{ asset('images/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-home icono"></i>Añadir</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users-cog icono"></i>Eliminar</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users-cog icono"></i>Modificar</a></li>
            </ul>
        </div>
    </nav>
    <input type="button" value="Ocultar" id="c1">
    <input type="button" value="Visualizar" id="c2">
        <?php foreach ($imgtab as $imgT) { ?>
            <form action="subcontextosUsuario" method="post">
                @csrf
                <input type="hidden" name="id" value="<?= $imgT->Id_imagen ?>">
                <button><img src="<?php echo $imgT->Ruta ?>" width="200" height="200"/></button>
                <input type="text" name="contexto" value="<?= $imgT->Nombre ?>">
            </form>
        <?php } ?>        
</main>
@endsection
