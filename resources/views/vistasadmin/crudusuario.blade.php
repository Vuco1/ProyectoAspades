@extends('plantillas/maestra')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('titulo')
@lang('messages.CrudAdminTitulo')
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
                <li class="nav-item active"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>@lang('messages.NavGestion')</a></li>
                <li class="nav-item"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>@lang('messages.NavPerfil')</a></li>
                <li class="nav-item"><a class="nav-link" href="personalizar"><i class="fas fa-user-cog icono"></i>@lang('messages.NavPersonalizar')</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_crud"><i class="fas fa-question-circle icono"></i>@lang('messages.NavAyuda')</a></li>
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
                                    <label class="sr-only" for="nick<?php echo $dato->Id_usuario ?>">Usuario</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text w-8"><i class="fas fa-user icono"></i>@lang('messages.CrudAdminUsuario')</div>
                                        </div>
                                        <input type="text" name="Nick" id="nick<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nick ?>" placeholder="Usuario" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="nombre<?php echo $dato->Id_usuario ?>">Nombre</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>@lang('messages.CrudAdminNombre')</div>
                                        </div>
                                        <input type="text" name="Nombre" id="nombre<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nombre ?>" placeholder="Nombre" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="sr-only" for="rol<?php echo $dato->Id_usuario ?>">Rol</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text w-8"><i class="fas fa-tag icono"></i>@lang('messages.CrudAdminRol')</div>
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
                                <button data-toggle="modal" data-target="#modificar" name="modificar" id="modificar<?php echo $dato->Id_usuario ?>" onclick="editarUsuario(<?php echo ($dato->Id_usuario . ', ' . $dato->Id_rol) ?>)" class="btn btn-info col mr-md-3"><i class="fas fa-pen pr-md-2"></i><span class="d-none d-md-inline">@lang('messages.CrudAdminBotonModificar')</span></button>
                                <button data-toggle="modal" data-target="#eliminar" name="eliminar" id="eliminar<?php echo $dato->Id_usuario ?>" onclick="eliminarUsuario(<?php echo $dato->Id_usuario ?>)" class="btn btn-danger col"><i class="fas fa-minus pr-md-2"></i><span class="d-none d-md-inline">@lang('messages.CrudAdminBotonEliminar')</span></button>
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
        <button data-toggle="modal" data-target="#nuevo" class="btn btn-success"><i class="fas fa-plus pr-md-2"></i>@lang('messages.CrudAdminBotonAñadir')</button>
    </div>
    <div id="paginacion" class="d-inline-flex w-100 align-content-center mt-3">
        {{ $datos->links() }}
    </div>
    <!-- VENTANA MODAL AÑADIR USUARIO -->
    <section class="modal fade" id="nuevo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">@lang('messages.ModalCrudAdd')</div>
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
                                    <span id="descripcionimagen" class="input-group-text w-8"><i class="fas fa-image icono"></i>@lang('messages.ModalCrudAddImagen')</span>
                                </div>
                                <div class="custom-file">
                                    <input name="imagen" id="imagen" type="file" class="custom-file-input" aria-describedby="descripcionimagen" onchange="cambiarTexto(this.id)">
                                    <label id="imagenlabel" for="imagen" class="custom-file-label">@lang('messages.ModalCrudAddImagenPH')</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="usuario">Usuario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>@lang('messages.ModalCrudAddUsuario')</div>
                                </div>
                                <input type="text" name="usuario" id="usuario" placeholder="@lang('messages.ModalCrudAddUsuario')" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>@lang('messages.ModalCrudAddNombre')</div>
                                </div>
                                <input type="text" name="nombre" id="nombre" placeholder="@lang('messages.ModalCrudAddNombre')" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="clavenuevo">Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>@lang('messages.ModalCrudAddClave')</div>
                                </div>
                                <input type="password" name="clavenuevo" id="clavenuevo" placeholder="@lang('messages.ModalCrudAddClavePH')" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="claverepenuevo">Confirmar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-copy icono"></i>@lang('messages.ModalCrudAddConfirmar')</div>
                                </div>
                                <input type="password" name="claverepenuevo" id="claverepenuevo" placeholder="@lang('messages.ModalCrudAddConfirmarPH')" class="form-control" onkeyup="validarClave('nuevo')" required>
                            </div>
                        </div>   
                        <div id="mensajenuevo" class="text-center text-danger"></div>
                        <div class="custom-control custom-checkbox mb-3 mt-3 text-center">
                            <input id="rol" type="checkbox" name="rol" value="Admin" class="custom-control-input">
                            <label for="rol" class="custom-control-label">@lang('messages.ModalCrudAddAdmin')</label>                              
                        </div>
                        <input type="submit" name="guardarnuevo" id="guardarnuevo" value="@lang('messages.ModalCrudAddBoton')" class="btn btn-color w-100">  
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
                    <div class="modal-title">@lang('messages.ModalCrudEditar')</div>
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
                                    <span id="descripcionimagenmod" class="input-group-text w-8"><i class="fas fa-image icono"></i>@lang('messages.ModalCrudEditarImagen')</span>
                                </div>
                                <div class="custom-file">
                                    <input name="imagenmod" id="imagenmod" type="file" class="custom-file-input" aria-describedby="descripcionimagenmod" onchange="cambiarTexto(this.id)">
                                    <label id="imagenmodlabel" for="imagenmod" class="custom-file-label">@lang('messages.ModalCrudEditarImagenPH')</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="usuariomod">Usuario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>@lang('messages.ModalCrudEditarUsuario')</div>
                                </div>
                                <input type="text" name="usuariomod" id="usuariomod" placeholder="@lang('messages.ModalCrudEditarUsuario')" value="" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombremod">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>@lang('messages.ModalCrudEditarNombre')</div>
                                </div>
                                <input type="text" name="nombremod" id="nombremod" placeholder="@lang('messages.ModalCrudEditarNombre')" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="rolmod">Rol</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-tag icono"></i>@lang('messages.ModalCrudEditarRol')</div>
                                </div>
                                <select name="rolmod" id="rolmod" class="custom-select">
                                    <?php foreach ($datos2 as $da2) { ?>
                                        <option id="rolop<?php echo $da2->Id_rol ?>" value="<?php echo $da2->Id_rol ?>"><?php echo $da2->Descripcion ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="clavemod">Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>@lang('messages.ModalCrudEditarClave')</div>
                                </div>
                                <input type="password" name="clavemod" id="clavemod" placeholder="@lang('messages.ModalCrudEditarClavePH')" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="claverepemod">Confirmar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-check-double icono"></i>@lang('messages.ModalCrudEditarConfirmar')</div>
                                </div>
                                <input type="password" name="claverepemod" id="claverepemod" placeholder="@lang('messages.ModalCrudEditarConfirmarPH')" class="form-control" onkeyup="validarClave('mod')">
                            </div>
                        </div>
                        <div id="mensajemod" class="text-center text-danger mb-3"></div>
                        <input type="submit" name="guardarmod" id="guardarmod" value="@lang('messages.ModalCrudEditarBoton')" class="btn btn-color w-100">  
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
                    <div class="modal-title">@lang('messages.ModalCrudEliminar')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarUsuario" method="post" class="text-center">
                        @csrf
                        <p>@lang('messages.ModalCrudEliminarP')</p>
                        <input type="hidden" name="idusuelim" id="idusuelim" value="">
                        <input type="submit" name="eliminar" id="eliminar" value="@lang('messages.ModalCrudEliminarBoton')" class="btn btn-color w-100">  
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
                <div class="modal-title">@lang('messages.ModalAyuda')</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-justify">
                <ul>
                    <li><p>@lang('messages.ModalCrudAyudaP1')</p></li>
                    <li><p>@lang('messages.ModalCrudAyudaP2')</p></li>
                    <li><p>@lang('messages.ModalCrudAyudaP3')</p></li>
                    <li><p>@lang('messages.ModalCrudAyudaP4')</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
    
</main>
@include('plantillas/footer')
@endsection
