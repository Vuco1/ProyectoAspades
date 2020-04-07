@extends('es/plantillas/maestra')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('titulo')
Gestión
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
                <li class="nav-item"><a class="nav-link" href="inicioadmin"><i class="fas fa-home icono"></i>Inicio</a></li>
                <li class="nav-item active"><a class="nav-link" href="gestionusuarios"><i class="fas fa-users-cog icono"></i>Gestión</a></li>
                <li class="nav-item"><a class="nav-link" href="perfil"><i class="fas fa-user-circle icono"></i>Perfil</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_crud"><i class="fas fa-question-circle icono"></i>Ayuda</a></li>
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
                                            <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Usuario</div>
                                        </div>
                                        <input type="text" name="Nick" id="nick<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nick ?>" placeholder="Usuario" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="nombre<?php echo $dato->Id_usuario ?>">Nombre</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Nombre</div>
                                        </div>
                                        <input type="text" name="Nombre" id="nombre<?php echo $dato->Id_usuario ?>" value="<?php echo $dato->Nombre ?>" placeholder="Nombre" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="sr-only" for="rol<?php echo $dato->Id_usuario ?>">Rol</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text w-8"><i class="fas fa-tag icono"></i>Rol</div>
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
                                <button data-toggle="modal" data-target="#modificar" name="modificar" id="modificar<?php echo $dato->Id_usuario ?>" onclick="editarUsuario(<?php echo ($dato->Id_usuario . ', ' . $dato->Id_rol) ?>)" class="btn btn-info col mr-md-3"><i class="fas fa-pen pr-md-2"></i><span class="d-none d-md-inline">Editar</span></button>
                                <button data-toggle="modal" data-target="#eliminar" name="eliminar" id="eliminar<?php echo $dato->Id_usuario ?>" onclick="eliminarUsuario(<?php echo $dato->Id_usuario ?>)" class="btn btn-danger col"><i class="fas fa-minus pr-md-2"></i><span class="d-none d-md-inline">Borrar</span></button>
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
        <button data-toggle="modal" data-target="#nuevo" class="btn btn-success"><i class="fas fa-plus pr-md-2"></i>Añadir Usuario</button>
    </div>
    <div id="paginacion" class="d-inline-flex w-100 align-content-center mt-3">
        {{ $datos->links() }}
    </div>
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
                    <form action="registrar" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="descripcionimagen" class="input-group-text w-8"><i class="fas fa-image icono"></i>Foto</span>
                                </div>
                                <div class="custom-file">
                                    <input name="imagen" id="imagen" type="file" class="custom-file-input" aria-describedby="descripcionimagen" onchange="cambiarTexto(this.id)">
                                    <label id="imagenlabel" for="imagen" class="custom-file-label">Selecciona una imagen...</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="usuario">Usuario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Usuario</div>
                                </div>
                                <input type="text" name="usuario" id="usuario" placeholder="Usuario" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Nombre</div>
                                </div>
                                <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="clavenuevo">Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>Contraseña</div>
                                </div>
                                <input type="password" name="clavenuevo" id="clavenuevo" placeholder="Escribe una contraseña" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="claverepenuevo">Confirmar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-copy icono"></i>Confirmar</div>
                                </div>
                                <input type="password" name="claverepenuevo" id="claverepenuevo" placeholder="Repite la contraseña" class="form-control" onkeyup="validarClave('nuevo')" required>
                            </div>
                        </div>   
                        <div id="mensajenuevo" class="text-center text-danger"></div>
                        <div class="custom-control custom-checkbox mb-3 mt-3 text-center">
                            <input id="rol" type="checkbox" name="rol" value="Admin" class="custom-control-input">
                            <label for="rol" class="custom-control-label">¿Hacer Administrador?</label>                              
                        </div>
                        <input type="submit" name="guardarnuevo" id="guardarnuevo" value="Añadir" class="btn btn-orange w-100">  
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
                    <div class="modal-title">Editar usuario</div>
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
                                    <span id="descripcionimagenmod" class="input-group-text w-8"><i class="fas fa-image icono"></i>Foto</span>
                                </div>
                                <div class="custom-file">
                                    <input name="imagenmod" id="imagenmod" type="file" class="custom-file-input" aria-describedby="descripcionimagenmod" onchange="cambiarTexto(this.id)">
                                    <label id="imagenmodlabel" for="imagenmod" class="custom-file-label">Selecciona una imagen...</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="usuariomod">Usuario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Usuario</div>
                                </div>
                                <input type="text" name="usuariomod" id="usuariomod" placeholder="Usuario" value="" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombremod">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Nombre</div>
                                </div>
                                <input type="text" name="nombremod" id="nombremod" placeholder="Nombre" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="rolmod">Rol</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-tag icono"></i>Rol</div>
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
                                    <div class="input-group-text w-8"><i class="fas fa-key icono"></i>Contraseña</div>
                                </div>
                                <input type="password" name="clavemod" id="clavemod" placeholder="Escribe la nueva contraseña" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="claverepemod">Confirmar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-check-double icono"></i>Confirmar</div>
                                </div>
                                <input type="password" name="claverepemod" id="claverepemod" placeholder="Repite la nueva contraseña" class="form-control" onkeyup="validarClave('mod')">
                            </div>
                        </div>
                        <div id="mensajemod" class="text-center text-danger mb-3"></div>
                        <input type="submit" name="guardarmod" id="guardarmod" value="Guardar" class="btn btn-orange w-100">  
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
                    <div class="modal-title">Borrar usuario</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarUsuario" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                        <input type="hidden" name="idusuelim" id="idusuelim" value="">
                        <input type="submit" name="eliminar" id="eliminar" value="Eliminar" class="btn btn-orange w-100">  
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
                <div class="modal-title">Ayuda</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-justify">
                <ul>
                    <li><p>Aquí podemos ver y modificar la información de todos los usuarios registrados en la aplicación. También podemos eliminar o añadir usuarios.</p></li>
                    <li><p>Si queremos eliminar a algún usuario de la aplicación, sólo tenemos que pulsar en el botón <span class="btn-danger px-1 md-3"><i class="fas fa-minus pr-md-2 icono"></i>Borrar</span>.</p></li>
                    <li><p>Para modificar los datos de algún usuario pulsamos en <span class="btn-info px-1 md-3"><i class="fas fa-pen pr-md-2 icono"></i>Editar</span>. Se nos abrirá una ventana modal en la que tenemos que introducir los datos que queramos cambiar.</p></li>
                    <li><p>Para añadir nuevos usuarios, pulsamos en <span class="btn-success px-1 md-3"><i class="fas fa-plus pr-md-2"></i>Añadir Usuario</span>. Se nos abrirá una ventana con un formulario que debemos rellenar con los datos del usuario.</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
    
</main>
@include('es/plantillas/footer')
@endsection
