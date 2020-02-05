@extends('plantillas/maestra')

<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('titulo')
Perfil
@endsection
@section('contenido')
<!-- HEADER -->
<header>
    <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="inicioadmin"><img src="{{ asset('images/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="inicioadmin"><i class="fas fa-home icono"></i>Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>Gestión</a></li>
                <li class="nav-item active"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>Perfil</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main>
    <?php foreach ($datos as $dato) { ?>
        <form id="form" name='form' class='form'>
            @csrf
            <input type="hidden" class="id" name="Id" id="id<?php echo $dato->Id_usuario ?>"  value="<?php echo $dato->Id_usuario ?>" >
            <input type="text" name="Nick"  id="nick<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nick ?>" >
            <input type="text" name="Nombre" id="nombre<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nombre ?>" >
            <select name="Rol" id="rol<?php echo $dato->Id_usuario ?>" class="form-control">
                <?php foreach ($datos2 as $da2) { ?>
                    <option name="" value="<?php echo $da2->Id_rol ?>"<?php if ($dato->Id_rol == $da2->Id_rol) { ?>selected<?php } ?>><?php echo $da2->Descripcion ?></option>
                    <?php
                }
                ?>
            </select>
            <button id="eliminar<?php echo $dato->Id_usuario ?>" class="formbutton" name="eliminar">Eliminar</button>
            <button id='modificar<?php echo $dato->Id_usuario ?>' class="formbutton" name="modificar">Modificar</button><br/>
        </form>
        <?php
    }
    ?>
    <a href="addUsuario">add</a>
    {{ $datos->links() }}
</main>
@include('plantillas/footer')
@endsection
