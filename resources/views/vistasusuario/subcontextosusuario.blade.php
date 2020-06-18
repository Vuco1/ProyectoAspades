@extends('plantillas/maestra')
@section('titulo')
@lang('messages.TituloTablero')
@endsection
@section('contenido')
<!-- HEADER -->
<header id="menuoculto" class="d-none">
    <nav id="menu" class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="iniciousuario"><img id="logo" src="" alt="Logo" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#divnav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="divnav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="iniciousuario"><i class="fas fa-home icono"></i>@lang('messages.NavInicio')</a></li>
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-user-circle icono"></i>@lang('messages.NavPerfil')</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_tablero"><i class="fas fa-question-circle icono"></i>@lang('messages.NavAyuda')</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th icono"></i>@lang('messages.NavAdministrarPanel')</a>
                    <div class="dropdown-menu w-100" aria-labelledby="navbarDropdown">
                        <form action='addpagina' method="post">
                            @csrf
                            <input type="hidden" name="anterior" value="{{ \Session::get('actual')}}">
                            <button class="dropdown-item"><i class="fas fa-plus-circle icono"></i>@lang('messages.NavAddPagina')</button>
                        </form>
                        <button class="dropdown-item" data-toggle="modal" data-target="#eliminarpagina" onclick="eliminarPagina()"><i class="fas fa-minus-circle icono"></i>@lang('messages.NavEliminarPagina')</button>
                        <button class="dropdown-item" data-toggle="modal" data-target="#vaciarpagina"><i class="fas fa-times-circle icono"></i>@lang('messages.NavVaciarPanel')</button>
                    </div>
                </li>
            </ul>
            <a class="text-secondary " href="cerrarsesion"><i class="fas fa-power-off h2 m-0 p-2 px-3"></i></a>
        </div>
    </nav>
</header>
<!-- MAIN -->
<main class="d-flex">
    <div id="carouselSubcontextos" class="carousel slide w-100" data-ride="carousel" data-interval="false" data-touch="true">
        <?php if (isset($paginas)) { ?>
            <ol class="carousel-indicators">
                <?php
                for ($i = 0; $i < $paginas; $i++) {
                    if ($i == 0) {
                        echo '<li id="pag' . ($i + 1) . '" data-target="#carouselSubcontextos" data-slide-to="0" class="active"></li>';
                    } else {
                        echo '<li id="pag' . ($i + 1) . '" data-target="#carouselSubcontextos" data-slide-to="' . $i . '"></li>';
                    }
                }
                ?>
            </ol>
        <?php } ?>
        <div class="carousel-inner h-100 d-flex">
            <?php
            $cont = 0;
            $pagActual = 1;
            for ($i = 1; $i <= $casTotal; $i++) {
                if ($cont % $casPorPag == 0) {
                    if ($cont == 0) {
                        echo '<div class="carousel-item active">';
                    } else {
                        echo '<div class="carousel-item">';
                    }
                    echo '<div class="' . $dimension->Dimension . '">';
                }
                ?>
                <div class="card">
                    <form id="form<?php echo $i ?>" name="formtablero" action="obtenersubcontextos" method="post" class="m-0">
                        @csrf
                        <button name="btnsubcon" class="btn p-0 w-100">                    
                            <img src="{{ $subcontextos[$i]->Imagen }}" alt="@lang('messages.TableroImagenAlt')" class="card-img-top img-subcontexto" style="height: calc((100vh / {{ $dimension->Filas }}) - 2.75rem)">
                            <div class="card-body p-2">
                                <input  type="hidden" name="nombre" value="{{ $subcontextos[$i]->Nombre }}" id="nombre<?php echo $i ?>">
                                <input type="hidden" name="posicion" id="posicion<?php echo $i ?>" value="<?php echo $i ?>">
                                <input type="hidden" name="actualtablero" id="actual<?php echo $i ?>" value="{{ $subcontextos[$i]->Id_tablero }}">
                                <input type="hidden" name="numfilas" id="numfilas<?php echo $i ?>" value="{{$dimension->Filas }}">
                                <input type="hidden" name="accion" id="accion<?php echo $i ?>" value="{{ $subcontextos[$i]->Accion }}">
                                <p id="leer<?php echo $i ?>" class="card-text">{{ $subcontextos[$i]->Nombre }}</p>
                            </div>
                        </button>                
                    </form>
                    <?php if ($dimension->Dimension == "grid-lg" && (3 * $pagActual - 1) == $i) { ?>
                        <div></div>
                    <?php } else { ?>            
                        <div class="card-footer d-none">
                            <div class="row px-2">
                                <?php if ($subcontextos[$i]->Imagen != "images/tabs/blanco.jpg") { ?>
                                    <button data-toggle="modal" data-target="#modificar" onclick="modificarContexto({{ $i }})" type="submit" name="modificarcontexto" id="modificar{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-info col mr-md-3"><i class="fas fa-pen pr-md-2"></i><span class="d-none d-md-inline">@lang('messages.TableroBotonEditar')</span></button>
                                    <button data-toggle="modal" data-target="#eliminar" onclick="eliminarContexto({{ $i }})" type="submit" name="eliminarcontexto" id="eliminar{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-danger col"><i class="fas fa-minus pr-md-2"></i><span class="d-none d-md-inline">@lang('messages.TableroBotonBorrar')</span></button>
                                <?php } else { ?>
                                    <button data-toggle="modal" data-target="#nuevosub" onclick="addContexto({{ $i }})" type="submit" name="nuevocontexto" id="nuevo{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-success col"><i class="fas fa-plus pr-md-2"></i><span class="d-none d-md-inline">@lang('messages.TableroBotonAddTablero')</span></button>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
                if (($cont + 1) % $casPorPag == 0) {
                    echo '</div></div>';
                }
                $cont++;
                if ($cont == $casPorPag + 1) {
                    $cont = 1;
                    $pagActual++;
                }
            }
            ?>
        </div>
    </div>
    <!-- VENTANA MODAL NUEVO SUBCONTEXTO -->
    <section class="modal fade" id="nuevosub">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">@lang('messages.ModalNuevoTablero')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form method=get action="http://www.arasaac.org/buscar.php?s=casa&idiomasearch=0&Buscar=Buscar&buscar_por=1&pictogramas_color=1" target="_blank">
                        <div class="form-group">
                            <label class="sr-only" for="buscador">Arasaac</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-search icono"></i>@lang('messages.ModalNuevoTableroArasaac')</div>
                                </div>
                                <input type="text" name="s" maxlength="255" value="" class="form-control" style="width: 10.4rem;">
                                <input type="hidden" name="idiomasearch" value="0">
                                <div class="custom-file">
                                <?php 
                                    $lang = session()->get('lang');
                                    if ( $lang == 'en' ){ ?>
                                    <input type="submit" name="Buscar" value="" >
                                <?php } else {?> 
                                    <input type="submit" name="Buscar" value="Buscar" class="custom-file-input">
                                <?php }?>
                                    <label class="custom-file-label rounded-right" for="image"></label>
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
                                    <span id="descripcionimagennuevo" class="input-group-text w-8"><i class="fas fa-image icono"></i>@lang('messages.ModalNuevoTableroImagen')</span>
                                </div>
                                <div class="custom-file">
                                <?php 
                                    if ( $lang == 'en' ){ ?>
                                    <input type="file" name="image" id="image" aria-describedby="descripcionimagennuevo" onchange="cambiarTexto(this.id)" required>
                                <?php } else { ?>
                                    <input type="file" name="image" id="image" class="custom-file-input" aria-describedby="descripcionimagennuevo" onchange="cambiarTexto(this.id)" required> 
                                <?php }?>
                                    <label id="imagelabel" class="custom-file-label" for="image">@lang('messages.ModalNuevoTableroImagenLB')</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>@lang('messages.ModalNuevoTableroNombre')</div>
                                </div>
                                <input type="text" name="nombre" id="nombre" placeholder="@lang('messages.ModalNuevoTableroNombre')" class="form-control" required>
                                <input type="text" name="puntero" id="id" class="form-control" value="<?php echo session()->get('idcontexto') ?>" hidden>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="sr-only" for="accion">Acción</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-play-circle icono"></i>@lang('messages.ModalNuevoTableroAccion')</div>
                                </div>
                                <select name="accion" class="custom-select" id="accion">
                                        <option value="1">@lang('messages.ModalNuevoTableroAccion1')</option>
                                        <option value="2">@lang('messages.ModalNuevoTableroAccion2')</option>
                                        <option value="3">@lang('messages.ModalNuevoTableroAccion3')</option>
                                        <option value="4">@lang('messages.ModalNuevoTableroAccion4')</option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="dimension">Tamaño</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-th-large icono"></i>@lang('messages.ModalNuevoTableroDimension')</div>
                                </div>
                                <select name="dimension" class="custom-select" id="dimension">
                                        <option value="1">@lang('messages.ModalNuevoSize1')</option>
                                        <option value="2">@lang('messages.ModalNuevoSize2')</option>
                                        <option value="3">@lang('messages.ModalNuevoSize3')</option>
                                </select>
                            </div> 
                        </div>
                        <input type="hidden" id="anterior" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="hidden" id="posiadd" name="posiadd" value="">
                        <input type="submit" name="guardar" id="nuevo" value="@lang('messages.ModalNuevoTableroBoton')" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- VENTANA MODAL MODIFICAR SUBCONTEXTO -->
    <section class="modal fade" id="modificar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">@lang('messages.ModalModificarTablero')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form method=get action="http://www.arasaac.org/buscar.php?s=casa&idiomasearch=0&Buscar=Buscar&buscar_por=1&pictogramas_color=1" target="_blank">
                        <div class="form-group">
                            <label class="sr-only" for="buscador">Arasaac</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-search icono"></i>@lang('messages.ModalModificarTableroArasaac')</div>
                                </div>
                                <input type="text" name="s" maxlength="255" value="" class="form-control" style="width: 10.4rem;">
                                <input type="hidden" name="idiomasearch" value="0">
                                <div class="custom-file">
                                <?php 
                                    $lang = session()->get('lang');
                                    if ( $lang == 'en' ){ ?>
                                    <input type="submit" name="Buscar" value="" >
                                <?php } else {?> 
                                    <input type="submit" name="Buscar" value="Buscar" class="custom-file-input">
                                <?php }?>
                                    <label class="custom-file-label rounded-right" for="image"></label>
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
                                    <span id="descripcionimagenmod" class="input-group-text w-8"><i class="fas fa-image icono"></i>@lang('messages.ModalModificarTableroImagen')</span>
                                </div>
                                <div class="custom-file">
                                <?php 
                                    if ( $lang == 'en' ){ ?>
                                    <input type="file" name="image" id="image" aria-describedby="descripcionimagenmod" onchange="cambiarTexto(this.id)">
                                <?php } else { ?>
                                    <input type="file" name="image" id="image" class="custom-file-input" aria-describedby="descripcionimagenmod" onchange="cambiarTexto(this.id)"> 
                                <?php }?>
                                    <label id="imagecontextolabel" class="custom-file-label" for="imagecontexto">@lang('messages.ModalModificarTableroImagenLB')</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>@lang('messages.ModalModificarTableroNombre')</div>
                                </div>                                
                                <input type="text" name="nombremod" id="nombremod" placeholder="@lang('messages.ModalModificarTableroNombre')" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="accion">Acción</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-play-circle icono"></i>@lang('messages.ModalNuevoTableroAccion')</div>
                                </div>
                                <select name="accionlist" class="custom-select" id="accionlist">
                                        <option value="1">@lang('messages.ModalNuevoTableroAccion1')</option>
                                        <option value="2">@lang('messages.ModalNuevoTableroAccion2')</option>
                                        <option value="3">@lang('messages.ModalNuevoTableroAccion3')</option>
                                        <option value="4">@lang('messages.ModalNuevoTableroAccion4')</option>
                                </select>
                            </div> 
                        </div>
                        <input type="hidden" id="actual" name="actual" value="">
                        <input type="hidden" id="anterior" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="hidden" id="posimo" name="posimo" value="">
                        <input type="submit" name="guardar" id="guardar" value="@lang('messages.ModalModificarTableroBoton')" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- VENTANA MODAL ELIMINAR TABLERO -->
    <section class="modal fade" id="eliminar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">@lang('messages.ModalEliminarTablero')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarTablero" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>@lang('messages.ModalEliminarTableroMensaje')</p>
                        <input type="hidden" name="idelim" id="idelim" value="">
                        <input type="hidden" id="anterior" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="submit" name="delete" id="delete" value="@lang('messages.ModalEliminarTableroBoton')" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- VENTANA MODAL ELIMINAR PAGINA -->
    <section class="modal fade" id="eliminarpagina">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">@lang('messages.ModalEliminarPagina')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarpagina" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>@lang('messages.ModalEliminarPaginaMensaje')</p>
                        <input type="hidden" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="hidden" id="elimpagina" name="pagina" value="">     
                        <input type="submit" name="delete" id="delete" value="@lang('messages.ModalEliminarPaginaBoton')" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- VENTANA MODAL VACIAR PÁGINA -->
    <section class="modal fade" id="vaciarpagina">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">@lang('messages.ModalVaciarPagina')</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="vaciartablero" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>@lang('messages.ModalVaciarPaginaMensaje1')</p>
                        <p>@lang('messages.ModalVaciarPaginaMensaje2')</p>
                        <input type="hidden" id="anterior" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="submit" name="delete" id="delete" value="@lang('messages.ModalVaciarPaginaBoton')" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
    
              <!--VENTANA MODAL DE AYUDA-->
    <section class="modal fade" id="ayuda_tablero">
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
                    <li><p>@lang('messages.ModalAyudaTableroP1')</p></li>
                    <li><p>@lang('messages.ModalAyudaTableroP2')</p></li>
                    <li><p>@lang('messages.ModalAyudaTableroP3')</p></li>
                    <li><p>@lang('messages.ModalAyudaTableroP4')</p></li>
                    <li><p>@lang('messages.ModalAyudaTableroP5')</p></li>
                    <li><p>@lang('messages.ModalAyudaTableroP6')</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
    
</main>
@include('plantillas/footer')
@endsection
