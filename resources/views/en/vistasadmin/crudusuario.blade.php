@extends('en/plantillas/maestra')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('titulo')
Users management
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
                <li class="nav-item"><a class="nav-link" href="inicioadmin"><i class="fas fa-home icono"></i>Welcome page</a></li>
                <li class="nav-item active"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>Users management</a></li>
                <li class="nav-item"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>My profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_crud"><i class="fas fa-question-circle icono"></i>Help</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="pt-5">
    <div class="pt-5 px-3 text-center">
        <div class="row text-center mb-3">
            <div class="card-deck m-auto">
                <?php foreach ($datos as $dato) { ?>
                    <div class="card card-contexto">
                        <form id="form<?php echo $dato->Id_usuario ?>" name="form" class="form container p-0 m-0">
                            @csrf
                            <input type="hidden" class="id" name="Id" id="id<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Id_usuario ?>">
                            <img id="img<?php echo $dato->Id_usuario ?>" src="<?php echo $dato->Foto ?>" alt="Foto de perfil" class="card-img-top img-contexto">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <label class="sr-only" for="nick<?php echo $dato->Id_usuario ?>">Nick name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Nick name</div>
                                        </div>
                                        <input type="text" name="Nick" id="nick<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nick ?>" placeholder="Nick name" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="nombre<?php echo $dato->Id_usuario ?>">Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Name</div>
                                        </div>
                                        <input type="text" name="Nombre" id="nombre<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nombre ?>" placeholder="Name" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="sr-only" for="rol<?php echo $dato->Id_usuario ?>">Role</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text w-8"><i class="fas fa-tag icono"></i>Role</div>
                                        </div>
                                        <select name="Rol" id="rol<?php echo $dato->Id_usuario ?>" class="custom-select" disabled>
                                            <?php foreach ($datos2 as $da2) { ?>
                                                <option name="" value="<?php echo $da2->Id_rol ?>"<?php if ($dato->Id_rol == $da2->Id_rol) { ?>selected<?php } ?>><?php echo $da2->Descripcion ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>               
                        </form>
                        <div class="card-footer">
                            <div class="row px-2">
                                <button data-toggle="modal" data-target="#modificar" name="modificar" id="modificar<?php echo $dato->Id_usuario ?>" onclick="editarUsuario(<?php echo ($dato->Id_usuario . ', ' . $dato->Id_rol) ?>)" class="btn btn-info col mr-md-3"><i class="fas fa-pen pr-md-2"></i><span class="d-none d-md-inline">Modify</span></button>
                                <button data-toggle="modal" data-target="#eliminar" name="eliminar" id="eliminar<?php echo $dato->Id_usuario ?>" onclick="eliminarUsuario(<?php echo $dato->Id_usuario ?>)" class="btn btn-danger col"><i class="fas fa-minus pr-md-2"></i><span class="d-none d-md-inline">Delete</span></button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button data-toggle="modal" data-target="#nuevo" class="btn btn-success"><i class="fas fa-plus pr-md-2"></i>Add new user</button>
    </div>
    <div id="paginacion" class="d-inline-flex w-100 align-content-center mt-3">
        {{ $datos->links() }}
    </div>
    <!-- VENTANA MODAL AÑADIR USUARIO -->
    <section class="modal fade" id="nuevo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Add new user</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="registrar" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="descripcionimagen" class="input-group-text w-8"><i class="fas fa-image icono"></i>Picture</span>
                                </div>
                                <div class="custom-file">
                                    <input name="imagen" id="imagen" type="file" class="custom-file-input" aria-describedby="descripcionimagen" onchange="cambiarTexto(this.id)">
                                    <label id="imagenlabel" for="imagen" class="custom-file-label">Choose a picture...</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="usuario">Nick name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Nick name</div>
                                </div>
                                <input type="text" name="usuario" id="usuario" placeholder="Nicka name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Name</div>
                                </div>
                                <input type="text" name="nombre" id="nombre" placeholder="Name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="clavenuevo">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>Password</div>
                                </div>
                                <input type="password" name="clavenuevo" id="clavenuevo" placeholder="Choose a password" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="claverepenuevo">Repeat password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-check-double icono"></i>Repeat</div>
                                </div>
                                <input type="password" name="claverepenuevo" id="claverepenuevo" placeholder="Repeat password" class="form-control" onkeyup="validarClave('nuevo')" required>
                            </div>
                        </div>   
                        <div id="mensajenuevo" class="text-center text-danger"></div>
                        <div class="custom-control custom-checkbox mb-3 mt-3 text-center">
                            <input id="rol" type="checkbox" name="rol" value="Admin" class="custom-control-input">
                            <label for="rol" class="custom-control-label">¿Manager?</label>                              
                        </div>
                        <input type="submit" name="guardarnuevo" id="guardarnuevo" value="Accept" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>  
    <!-- VENTANA MODAL MODIFICAR USUARIO -->
    <section class="modal fade" id="modificar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Modify data</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="updateusuario" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="idusumod" id="idusumod" value="">
                        <input type="hidden" name="idrol" id="idrol" value=""/>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="descripcionimagenmod" class="input-group-text w-8"><i class="fas fa-image icono"></i>Picture</span>
                                </div>
                                <div class="custom-file">
                                    <input name="imagenmod" id="imagenmod" type="file" class="custom-file-input" aria-describedby="descripcionimagenmod" onchange="cambiarTexto(this.id)">
                                    <label id="imagenmodlabel" for="imagenmod" class="custom-file-label">Choose a picture...</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="usuariomod">Nick name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Nick name</div>
                                </div>
                                <input type="text" name="usuariomod" id="usuariomod" placeholder="Nick name" value="" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombremod">Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Name</div>
                                </div>
                                <input type="text" name="nombremod" id="nombremod" placeholder="Name" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="rolmod">Role</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-tag icono"></i>Role</div>
                                </div>
                                <select name="rolmod" id="rolmod" class="custom-select">
                                    <?php foreach ($datos2 as $da2) { ?>
                                        <option id="rolop<?php echo $da2->Id_rol ?>" value="<?php echo $da2->Id_rol ?>"><?php echo $da2->Descripcion ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="clavemod">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>Password</div>
                                </div>
                                <input type="password" name="clavemod" id="clavemod" placeholder="Write a new password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="claverepemod">Repeat password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-check-double icono"></i>Repeat</div>
                                </div>
                                <input type="password" name="claverepemod" id="claverepemod" placeholder="Repeat new password" class="form-control" onkeyup="validarClave('mod')">
                            </div>
                        </div>
                        <div id="mensajemod" class="text-center text-danger mb-3"></div>
                        <input type="submit" name="guardarmod" id="guardarmod" value="Accept" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- VENTANA MODAL ELIMINAR USUARIO -->
    <section class="modal fade" id="eliminar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Delete user</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarUsuario" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>Are you sure you want to delete this user?</p>
                        <input type="hidden" name="idusuelim" id="idusuelim" value="">
                        <input type="submit" name="eliminar" id="eliminar" value="Delete" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    
          <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_crud">
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
                    <li><p>Here we can see all the data from the registered users and modify it if we want. We can also delete or add new users.</p></li>
                    <li><p>If we want to delete any user we have to click on <span class="btn-danger px-1 md-3"><i class="fas fa-minus pr-md-2 icono"></i>Delete</span> and accept.</p></li>
                    <li><p>To modify any user's data, we have to click on <span class="btn-info px-1 md-3"><i class="fas fa-pen pr-md-2 icono"></i>Modify</span>. This will open a new window where we have to write anything we want to change.</p></li>
                    <li><p>If we want to add a new user, we have to click on <span class="btn-success px-1 md-3"><i class="fas fa-plus pr-md-2"></i>Add new user</span>. This will open a new window where we have to write all the data for the new user.</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
    
</main>
@include('en/plantillas/footer')
@endsection
