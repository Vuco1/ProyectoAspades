@extends('plantillas/maestra')
@section('titulo')
@lang('messages.TituloPanel')
@endsection
@section('contenido')
<!-- HEADER -->
<header id="menuoculto" class="d-none">
    <nav id="menu" class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="iniciousuario"><img src="{{ asset('images/icons/logo_aspades.svg') }}" alt="Logo" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#divnav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="divnav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="iniciousuario"><i class="fas fa-home icono"></i>@lang('messages.NavInicio')</a></li>
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-user-circle icono"></i>@lang('messages.NavPerfil')</a></li>
                <li class="nav-item"><button class="nav-link border-0 bg-transparent" data-toggle="modal" data-target="#nuevo"><i class="fas fa-plus-circle icono"></i>@lang('messages.NavAdd')</button></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_panel"><i class="fas fa-question-circle icono"></i>@lang('messages.NavAyuda')</a></li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="d-flex">
    <div id="carouselContextos" class="carousel slide m-auto px-5" data-ride="carousel" data-interval="false" data-touch="true">
        <?php if ($contextos) { ?>
            <ol class="carousel-indicators">
                <?php
                $i = 0;
                $pag = 1;
                foreach ($contextos as $c) {
                    if ($i % 3 == 0) {
                        if ($i == 0) {
                            echo '<li data-target="#carouselContextos" data-slide-to="0" class="active"></li>';
                        } else {
                            echo '<li data-target="#carouselContextos" data-slide-to="' . $pag . '"></li>';
                            $pag++;
                        }
                    }
                    $i++;
                }
                ?>
            </ol>
        <?php } ?>
        <div class="carousel-inner h-100">
            <?php if (!$contextos) { ?>
                <div class="text-center">
                    <h2 class="m-auto">@lang('messages.PanelH2')</h2>
                    <h3 class="m-auto">@lang('messages.PanelH3')</h3>
                </div>
                <?php
            } else {
                $cont = 0;
                foreach ($contextos as $c) {
                    if ($cont % 3 == 0) { //Cada 3 contextos se añade un item al carrousel
                        if ($cont == 0) {
                            echo '<div class="carousel-item active">';
                        } else {
                            echo '<div class="carousel-item">';
                        }
                        echo '<div class="card-deck">';
                    }
                    ?>
                    <div class="card card-contexto">
                        <form id="form<?php echo $cont ?>" name="formtablero" action="obtenersubcontextos" method="post" class="m-0">
                            @csrf
                            <input type="hidden" name="actual" value="{{ $c->Id_tablero }}">
                            <button name="btncon" class="btn p-0 w-100">
                                <img id="img{{ $c->Id_tablero }}" src="{{ $c->Imagen }}" alt="@lang('messages.PanelImagenAlt')" class="card-img-top img-contexto">
                                <div class="card-body p-2">
                                    <input  type="hidden" name="nombre" value="{{ $c->Nombre }}" id="nombre{{ $c->Id_tablero }}">
                                    <input  type="hidden" name="actualtablero" value="{{ $c->Id_tablero }}" id="actual{{ $c->Id_tablero }}">
                                    <p id="leer<?php echo $cont ?>" class="card-text">{{ $c->Nombre }}</p>
                                </div>
                            </button>                
                        </form>
                        <div class="card-footer d-none">
                            <div class="row px-2">
                                <button data-toggle="modal" data-target="#modificar" id="modificar{{ $c->Id_tablero }}" onclick="modificarContexto({{ $c->Id_tablero }})" class="btn btn-info col mr-md-3"><i class="fas fa-pen pr-md-2"></i><span class="d-none d-md-inline">@lang('messages.EditarPanel')</span></button>
                                <button data-toggle="modal" data-target="#eliminar" id="eliminar{{ $c->Id_tablero }}" onclick="eliminarContexto({{ $c->Id_tablero }})" class="btn btn-danger col"><i class="fas fa-minus pr-md-2"></i><span class="d-none d-md-inline">@lang('messages.BorrarPanel')</span></button>
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
                    <div class="modal-title">@lang('messages.ModalNuevoPanel')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form method=get action="http://www.arasaac.org/buscar.php?s=casa&idiomasearch=0&Buscar=Buscar&buscar_por=1&pictogramas_color=1" target="_blank">
                        <div class="form-group">
                            <label class="sr-only" for="buscador">Buscar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-search icono"></i>@lang('messages.ModalNuevoArasaac')</div>
                                </div>
                                <input type="text" name="s" maxlength="255" value="" class="form-control" style="width: 10.4rem;">
                                <input type="hidden" name="idiomasearch" value="0">
                                <div class="custom-file">
                                    <input type="submit" name="Buscar" value="Buscar" class="custom-file-input">
                                    <label class="custom-file-label rounded-right" for="Buscar"></label>
                                </div>
                                <input type="hidden" name="buscar_por" value="1">
                                <input type="hidden" name="pictogramas_color" value="1">
                            </div>
                        </div>
                    </form>
                    <form action="subirTablero" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="descripcionimagennuevo" class="input-group-text w-8"><i class="fas fa-image icono"></i>@lang('messages.ModalNuevoImagen')</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="image" class="custom-file-input" aria-describedby="descripcionimagennuevo" onchange="cambiarTexto(this.id)" required>
                                    <label id="imagelabel" class="custom-file-label" for="image">@lang('messages.ModalNuevoImagenLB')</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>@lang('messages.ModalNuevoNombre')</div>
                                </div>
                                <input type="text" name="nombre" id="nombre" placeholder="@lang('messages.ModalNuevoNombre')" class="form-control" required>
                                <input type="text" name="puntero" id="id" class="form-control" value="<?php echo session()->get('idcontexto') ?>" hidden>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="dimension">Tamaño</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-th-large icono"></i>@lang('messages.ModalNuevoDimension')</div>
                                </div>
                                <select name="dimension" class="custom-select" id="dimension">
                                    <?php foreach ($dimensiones as $d) { ?>
                                        <option value="<?= $d->Id_dimension ?>"><?= $d->Nombre ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <input type="submit" name="guardar" id="nuevo" value="@lang('messages.ModalNuevoBoton')" class="btn btn-orange w-100">  
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
                    <div class="modal-title">@lang('messages.ModalModificarPanel')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form method=get action="http://www.arasaac.org/buscar.php?s=casa&idiomasearch=0&Buscar=Buscar&buscar_por=1&pictogramas_color=1" target="_blank">
                        <div class="form-group">
                            <label class="sr-only" for="buscador">Buscar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-search icono"></i>@lang('messages.ModalModificarArasaac')</div>
                                </div>
                                <input type="text" name="s" maxlength="255" value="" class="form-control" style="width: 10.4rem;">
                                <input type="hidden" name="idiomasearch" value="0">
                                <div class="custom-file">
                                    <input type="submit" name="Buscar" value="Buscar" class="custom-file-input">
                                    <label class="custom-file-label rounded-right" for="Buscar"></label>
                                </div>
                                <input type="hidden" name="buscar_por" value="1">
                                <input type="hidden" name="pictogramas_color" value="1">
                            </div>
                        </div>
                    </form>
                    <form action="modificarTablero" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="descripcionimagenmod" class="input-group-text w-8"><i class="fas fa-image icono"></i>@lang('messages.ModalModificarImagen')</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="imagecontexto" class="custom-file-input" aria-describedby="descripcionimagenmod" onchange="cambiarTexto(this.id)">
                                    <label id="imagecontextolabel" class="custom-file-label" for="imagecontexto">@lang('messages.ModalModificarImagenLB')</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>@lang('messages.ModalModificarNombre')</div>
                                </div>
                                <input type="hidden" id="posimo" name="posimo" value="1">
                                <input type="hidden" id="actual" name="actual" value="">
                                <input type="text" name="nombremod" id="nombremod" placeholder="@lang('messages.ModalModificarNombre')" class="form-control" value="">
                            </div>
                        </div> 
                        <input type="submit" name="guardar" id="guardar" value="@lang('messages.ModalModificarBoton')" class="btn btn-orange w-100">  
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
                    <div class="modal-title">@lang('messages.ModalEliminarPanel')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarTablero" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>@lang('messages.ModalEliminarPanelMensaje')</p>
                        <input type="hidden" name="idelim" id="idelim" value="">
                        <input type="hidden" id="actual" name="actual" value="">
                        <input type="submit" name="delete" id="delete" value="@lang('messages.ModalEliminarBoton')" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    
              <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_panel">
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
                    <li><p>@lang('messages.ModalAyudaPanelP1')</p></li>
                    <li><p>@lang('messages.ModalAyudaPanelP2')</p></li>
                    <li><p>@lang('messages.ModalAyudaPanelP3')</p></li>
                    <li><p>@lang('messages.ModalAyudaPanelP4')</p></li>
                    <li><p>@lang('messages.ModalAyudaPanelP5')</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
    
</main>
@include('plantillas/footer')
@endsection
