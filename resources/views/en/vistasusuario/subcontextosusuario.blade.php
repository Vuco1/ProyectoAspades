@extends('en/plantillas/maestra')
@section('titulo')
Gallery
@endsection
@section('contenido')
<!-- HEADER -->
<header id="menuoculto" class="d-none">
    <nav id="menu" class="navbar navbar-expand-md navbar-light bg-light p-0">
        <a class="py-2 px-3" href="iniciousuario"><img src="{{ asset('images/icons/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#divnav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="divnav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="iniciousuario"><i class="fas fa-home icono"></i>Welcome page</a></li>
                <li class="nav-item"><a class="nav-link" href="perfilusuario"><i class="fas fa-user-circle icono"></i>My profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_tablero"><i class="fas fa-question-circle icono"></i>Help</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th icono"></i>Gallery management</a>
                    <div class="dropdown-menu w-100" aria-labelledby="navbarDropdown">
                        <form action='addpagina' method="post">
                            @csrf
                            <input type="hidden" name="anterior" value="{{ \Session::get('actual')}}">
                            <button class="dropdown-item"><i class="fas fa-plus-circle icono"></i>Add new page</button>
                        </form>
                        <button class="dropdown-item" data-toggle="modal" data-target="#eliminarpagina" onclick="eliminarPagina()"><i class="fas fa-minus-circle icono"></i>Delete current page</button>
                        <button class="dropdown-item" data-toggle="modal" data-target="#vaciarpagina"><i class="fas fa-times-circle icono"></i>Empty gallery</button>
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
                            <img src="{{ $subcontextos[$i]->Imagen }}" alt="Gallery picture" class="card-img-top img-subcontexto" style="height: calc((100vh / {{ $dimension->Filas }}) - 2.75rem)">
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
                                    <button data-toggle="modal" data-target="#modificar" onclick="modificarContexto({{ $i }})" type="submit" name="modificarcontexto" id="modificar{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-info col mr-md-3"><i class="fas fa-pen pr-md-2"></i><span class="d-none d-md-inline">Modify</span></button>
                                    <button data-toggle="modal" data-target="#eliminar" onclick="eliminarContexto({{ $i }})" type="submit" name="eliminarcontexto" id="eliminar{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-danger col"><i class="fas fa-minus pr-md-2"></i><span class="d-none d-md-inline">Delete</span></button>
                                <?php } else { ?>
                                    <button data-toggle="modal" data-target="#nuevosub" onclick="addContexto({{ $i }})" type="submit" name="nuevocontexto" id="nuevo{{ $subcontextos[$i]->Id_tablero }}" class="btn btn-success col"><i class="fas fa-plus pr-md-2"></i><span class="d-none d-md-inline">Add new gallery</span></button>
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
                    <div class="modal-title">Add new gallery</div>
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
                                    <div class="input-group-text w-8"><i class="fas fa-search icono"></i>Arasaac</div>
                                </div>
                                <input type="text" name="s" maxlength="255" value="" class="form-control" style="width: 10.4rem;">
                                <input type="hidden" name="idiomasearch" value="0">
                                <div class="custom-file">
                                    <input type="submit" name="Buscar" value="Buscar" class="custom-file-input">
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
                                    <span id="descripcionimagennuevo" class="input-group-text w-8"><i class="fas fa-image icono"></i>Picture</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="image" class="custom-file-input" aria-describedby="descripcionimagennuevo" onchange="cambiarTexto(this.id)" required>
                                    <label id="imagelabel" class="custom-file-label" for="image">Choose a picture...</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Name</div>
                                </div>
                                <input type="text" name="nombre" id="nombre" placeholder="Name" class="form-control" required>
                                <input type="text" name="puntero" id="id" class="form-control" value="<?php echo session()->get('idcontexto') ?>" hidden>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="sr-only" for="accion">Action</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-play-circle icono"></i>Action</div>
                                </div>
                                <select name="accion" class="custom-select" id="accion">
                                    <?php foreach ($acciones as $accion) { ?>
                                        <option value="<?= $accion->Id_accion ?>"><?= $accion->Nombre ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="dimension">Size</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-th-large icono"></i>Size</div>
                                </div>
                                <select name="dimension" class="custom-select" id="dimension">
                                    <?php foreach ($dimensiones as $d) { ?>
                                        <option value="<?= $d->Id_dimension ?>"><?= $d->Nombre ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <input type="hidden" id="anterior" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="hidden" id="posiadd" name="posiadd" value="">
                        <input type="submit" name="guardar" id="nuevo" value="Add new gallery" class="btn btn-orange w-100">  
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
                    <div class="modal-title">Modify gallery</div>
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
                                    <div class="input-group-text w-8"><i class="fas fa-search icono"></i>Arasaac</div>
                                </div>
                                <input type="text" name="s" maxlength="255" value="" class="form-control" style="width: 10.4rem;">
                                <input type="hidden" name="idiomasearch" value="0">
                                <div class="custom-file">
                                    <input type="submit" name="Buscar" value="Buscar" class="custom-file-input">
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
                                    <span id="descripcionimagenmod" class="input-group-text w-8"><i class="fas fa-image icono"></i>Picture</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="imagecontexto" class="custom-file-input" aria-describedby="descripcionimagenmod" onchange="cambiarTexto(this.id)">
                                    <label id="imagecontextolabel" class="custom-file-label" for="imagecontexto">Choose a picture...</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="nombre">Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-address-card icono"></i>Name</div>
                                </div>                                
                                <input type="text" name="nombremod" id="nombremod" placeholder="Name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="accion">Action</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-play-circle icono"></i>Action</div>
                                </div>
                                <select name="accionlist" class="custom-select" id="accionlist">
                                    <?php foreach ($acciones as $accion) { ?>
                                        <option value="<?= $accion->Id_accion ?>"><?= $accion->Nombre ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <input type="hidden" id="actual" name="actual" value="">
                        <input type="hidden" id="anterior" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="hidden" id="posimo" name="posimo" value="">
                        <input type="submit" name="guardar" id="guardar" value="Save changes" class="btn btn-orange w-100">  
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
                    <div class="modal-title">Delete gallery</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarTablero" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>Are you sure you want to delete this gallery?</p>
                        <input type="hidden" name="idelim" id="idelim" value="">
                        <input type="hidden" id="anterior" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="submit" name="delete" id="delete" value="Delete" class="btn btn-orange w-100">  
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
                    <div class="modal-title">Delete current page</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarpagina" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>Are you sure you want to delete this page?</p>
                        <input type="hidden" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="hidden" id="elimpagina" name="pagina" value="">     
                        <input type="submit" name="delete" id="delete" value="Delete" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- VENTANA MODAL VACIAR TABLERO -->
    <section class="modal fade" id="vaciarpagina">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Empty gallery</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="vaciartablero" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>Are you sure you want to empty this gallery?</p>
                        <p>(This will delete all the galleries inside the current one)</p>
                        <input type="hidden" id="anterior" name="anterior" value="{{ \Session::get('actual') }}">
                        <input type="submit" name="delete" id="delete" value="Empty" class="btn btn-orange w-100">  
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
                <div class="modal-title">Help</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-justify">
                <ul>
                    <li><p>Here we can see, modify, add and delete our gallerys.</p></li>
                    <li><p>To add a new gallery we should click on <span class="btn-success px-1 md-3"><i class="fas fa-plus pr-md-2 icono"></i>Add new gallery</span>. Then we choose a picture, a name, an action we want to asign and the size.</p></li>
                    <li><p>We can also look for a picture in the ARASAAC web page. We should write a word, download the one that suites best and upload it.</p></li>
                    <li><p>To modify a gallery whe should click on <span class="btn-info px-1 md-3"><i class="fas fa-pen pr-md-2 icono"></i>Modify</span> and change all the information needed.</p></li>
                    <li><p>To delete a gallery whe should click on <span class="btn-danger px-1 md-3"><i class="fas fa-minus pr-md-2 icono"></i>Delete</span> and the web will load again without the gallery we have chosen.</p></li>
                    <li><p>In the <span class="text-secondary px-1"><i class="fas fa-th icono"></i>Gallery management</span> menu we can: add a new page with <span class="text-secondary px-1"><i class="fas fa-plus-circle icono"></i>Add new page</span>, delete the current page with <span class="text-secondary px-1"><i class="fas fa-minus-circle icono"></i>Delete current page</span> or empty the gallery with <span class="text-secondary px-1"><i class="fas fa-times-circle icono"></i>Empty gallery</span>.</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
    
</main>
@include('en/plantillas/footer')
@endsection
