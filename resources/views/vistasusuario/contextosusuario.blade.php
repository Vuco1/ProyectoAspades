@extends('plantillas/maestra')
@section('titulo')
Contextos
@endsection
@section('contenido')
<!-- HEADER -->
<header id="menuoculto" style="display: none;">
    <nav id="menu" class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="iniciousuario"><img src="{{ asset('images/icons/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><div>
                        <button data-toggle="modal" data-target="#nuevo" class="btn btn-orange">Añadir Imagen</button>
                    </div></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users-cog icono"></i>Eliminar</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users-cog icono"></i>Modificar</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="d-flex">
    <div id="carouselContextos" class="carousel slide m-auto px-5" data-ride="carousel" data-interval="false" data-touch="true">
        <div class="carousel-inner">
            <?php if (!$contextos) { ?>
                <h1>Sin Resultados</h1><?php
            } else {
                $cont = 0;
                foreach ($contextos as $imgT) {
                    if ($cont % 3 == 0) { //Cada 3 contextos se añade un item al carrousel
                        if ($cont == 0) {
                            echo '<div class="carousel-item active">';
                        } else {
                            echo '<div class="carousel-item">';
                        }
                        echo '<div class="card-deck">';
                    }
                    ?>
                    <div class="card">
                        <form id="form<?php echo $cont ?>" name="formtablero" action="obtenersubcontextos" method="post" class="m-0">
                            @csrf
                            <input type="hidden" name="puntero" value="{{ $imgT->Id_imagen }}">
                            <button class="btn p-0 w-100">
                                <img id="img{{ $imgT->Id_imagen }}" src="{{ $imgT->Ruta }}" alt="Imagen del contexto" class="card-img-top img-contexto">
                                <div class="card-body p-2">
                                    <input  type="hidden" name="nombre" value="{{ $imgT->Nombre }}" id="nombre{{ $imgT->Id_imagen }}">
                                    <p id="leer<?php echo $cont ?>" class="card-text">{{ $imgT->Nombre }}</p>
                                </div>
                            </button>                
                        </form>
                        <div id="card_footer" class="card-footer" style="display: none;">
                            <div class="row px-2">
                                <button data-toggle="modal" data-target="#modificar" id="modificar{{ $imgT->Id_imagen }}" class="btn btn-success col mr-md-3" onclick="modificarContexto({{ $imgT -> Id_imagen }})"><img src="{{ asset('images/icons/check-solid.svg') }}" class="icono-crud"/><span class="d-none d-md-inline">Editar</span></button>
                                <button data-toggle="modal" data-target="#eliminar" id="eliminar{{ $imgT->Id_imagen }}" class="btn btn-danger col" onclick="eliminarContexto({{ $imgT -> Id_imagen }})"><img src="{{ asset('images/icons/times-solid.svg') }}" class="icono-crud"/><span class="d-none d-md-inline">Borrar</span></button>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (($cont + 1) % 3 == 0) {
                        echo '</div>'
                        . '</div>';
                    }
                    $cont++;
                }
            }
            ?>
        </div>
    </div>
    <!-- VENTANA MODAL NUEVO CONTEXTO -->
    <section class="modal fade" id="nuevo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Nuevo Contexto</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="subirTablero" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="sr-only" for="Foto">Foto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Foto</div>
                                </div>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Nombre</div>
                                </div>
                                <input type="text" name="nombre" id="nombre"  placeholder="Nombre" class="form-control">
                                <input type="text" name="puntero" id="id" class="form-control" value="<?php echo session()->get('idcontexto') ?>">
                            </div>
                        </div> 
                        <input type="submit" name="guardar" id="guardar" value="Añadir" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- VENTANA MODAL MODIFICAR CONTEXTO -->
    <section class="modal fade" id="modificar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Modificar Contexto</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <img id="imgcontexto" src="" class="img-perfil" alt="Imagen del contexto">
                    <form action="modificarContexto" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="sr-only" for="Foto">Foto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-user icono"></i>Foto</div>
                                </div>
                                <input type="file" name="image" id="imagecontexto" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Nombre</div>
                                </div>
                                <input type="hidden" id="idimg" name="idimg" value="">
                                <input type="text" name="nombre" id="nombrecontexto"  placeholder="Nombre" class="form-control">
                            </div>
                        </div> 
                        <input type="submit" name="guardar" id="guardar" value="Añadir" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- VENTANA MODAL ELIMINAR -->
    <section class="modal fade" id="eliminar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Nuevo Contexto</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarContexto" method="post" enctype="multipart/form-data">
                        @csrf
                        <p>Estas seguro de que deseas elimar este contexto </p>
                        <input type="hidden" name="idelim" id="idelim" value="">
                        <input type="submit" name="delete" id="delete" value="eliminar" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@include('plantillas/footer')
@endsection
