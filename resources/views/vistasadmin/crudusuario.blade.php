@extends('plantillas/maestra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('titulo')
Gestión
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
                <li class="nav-item active"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>Gestión</a></li>
                <li class="nav-item"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>Perfil</a></li>
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
            <input type="hidden" class="id" name="Id" id="id<?php echo $dato->Id_usuario ?>"  value="<?php echo $dato->Id_usuario ?>" class="" >
            <input type="text" name="Nick"  id="nick<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nick ?>"  class="">
            <input type="text" name="Nombre" id="nombre<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nombre ?>"  class="">
            <select name="Rol" id="rol<?php echo $dato->Id_usuario ?>" class="form-control">
                <?php foreach ($datos2 as $da2) { ?>
                    <option name="" value="<?php echo $da2->Id_rol ?>"<?php if ($dato->Id_rol == $da2->Id_rol) { ?>selected<?php } ?> class=""><?php echo $da2->Descripcion ?></option>
                    <?php
                }
                ?>
            </select>
            <button id="eliminar<?php echo $dato->Id_usuario ?>" name="eliminar"  class="formbutton">Eliminar</button>
            <button id='modificar<?php echo $dato->Id_usuario ?>'  name="modificar"class="formbutton">Modificar</button><br/>
        </form>
        <?php
    }
    ?>
    <button data-toggle="modal" data-target="#nuevo" class="btn btn-orange">Añadir Usuario</button>
    {{ $datos->links() }}
    <!-- VENTANA MODAL AÑADIR USUARIO -->
    <section class="modal fade" id="nuevo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Añadir Usuario</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="registrar" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="sr-only" for="usuario">Usuario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Usuario</div>
                                </div>
                                <input type="text" name="usuario" id="usuario" placeholder="Usuario" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Nombre</div>
                                </div>
                                <input type="text" name="nombre" id="nombre"  placeholder="Nombre" class="form-control">
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
                        <div class="custom-control custom-checkbox mb-3">
                            <input id="rol" type="checkbox" name="rol" value="Admin" class="custom-control-input">
                            <label for="rol" class="custom-control-label">¿Hacer Administrador?</label>                              
                        </div>
                        <input type="submit" name="validar" id="validar" value="Añadir" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@include('plantillas/footer')
@endsection
