@extends('en/plantillas/maestra')
@section('titulo')
Board
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
                <li class="nav-item"><button class="nav-link border-0 bg-transparent" data-toggle="modal" data-target="#nuevo"><i class="fas fa-plus-circle icono"></i>Add new board</button></li>
                <li class="nav-item"><a class="nav-link" href="#" data-toggle = "modal" data-target = "#ayuda_panel"><i class="fas fa-question-circle icono"></i>Help</a></li>
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
                    <h2 class="m-auto">You don't have any boards yet.</h2>
                    <h3 class="m-auto">Add one from the <span class="text-orange"><i class="fas fa-plus-circle icono"></i>Add new board</span> option from the menu <span class="text-orange"><i class="fas fa-lock icono"></i>Board management</span>.</h3>
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
                                <img id="img{{ $c->Id_tablero }}" src="{{ $c->Imagen }}" alt="Board picture" class="card-img-top img-contexto">
                                <div class="card-body p-2">
                                    <input  type="hidden" name="nombre" value="{{ $c->Nombre }}" id="nombre{{ $c->Id_tablero }}">
                                    <input  type="hidden" name="actualtablero" value="{{ $c->Id_tablero }}" id="actual{{ $c->Id_tablero }}">
                                    <p id="leer<?php echo $cont ?>" class="card-text">{{ $c->Nombre }}</p>
                                </div>
                            </button>                
                        </form>
                        <div class="card-footer d-none">
                            <div class="row px-2">
                                <button data-toggle="modal" data-target="#modificar" id="modificar{{ $c->Id_tablero }}" onclick="modificarContexto({{ $c->Id_tablero }})" class="btn btn-info col mr-md-3"><i class="fas fa-pen pr-md-2"></i><span class="d-none d-md-inline">Modify</span></button>
                                <button data-toggle="modal" data-target="#eliminar" id="eliminar{{ $c->Id_tablero }}" onclick="eliminarContexto({{ $c->Id_tablero }})" class="btn btn-danger col"><i class="fas fa-minus pr-md-2"></i><span class="d-none d-md-inline">Delete</span></button>
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
                    <div class="modal-title">New board</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form method=get action="http://www.arasaac.org/buscar.php?s=casa&idiomasearch=0&Buscar=Buscar&buscar_por=1&pictogramas_color=1" target="_blank">
                        <div class="form-group">
                            <label class="sr-only" for="buscador">Search</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-search icono"></i>Arasaac</div>
                                </div>
                                <input type="text" name="s" maxlength="255" value="" class="form-control" style="width: 10.4rem;">
                                <input type="hidden" name="idiomasearch" value="0">
                                <div class="custom-file">
                                    <input type="submit" name="Buscar" value="Search" class="custom-file-input">
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
                        <input type="submit" name="guardar" id="nuevo" value="Add new board" class="btn btn-orange w-100">  
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
                    <div class="modal-title">Modify board</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form method=get action="http://www.arasaac.org/buscar.php?s=casa&idiomasearch=0&Buscar=Buscar&buscar_por=1&pictogramas_color=1" target="_blank">
                        <div class="form-group">
                            <label class="sr-only" for="buscador">Search</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text w-8"><i class="fas fa-search icono"></i>Arasaac</div>
                                </div>
                                <input type="text" name="s" maxlength="255" value="" class="form-control" style="width: 10.4rem;">
                                <input type="hidden" name="idiomasearch" value="0">
                                <div class="custom-file">
                                    <input type="submit" name="Buscar" value="Search" class="custom-file-input">
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
                                <input type="hidden" id="posimo" name="posimo" value="1">
                                <input type="hidden" id="actual" name="actual" value="">
                                <input type="text" name="nombremod" id="nombremod" placeholder="Name" class="form-control" value="">
                            </div>
                        </div> 
                        <input type="submit" name="guardar" id="guardar" value="Save changes" class="btn btn-orange w-100">  
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
                    <div class="modal-title">Delete board</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="eliminarTablero" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <p>Are you sure you want to delete this board?</p>
                        <input type="hidden" name="idelim" id="idelim" value="">
                        <input type="hidden" id="actual" name="actual" value="">
                        <input type="submit" name="delete" id="delete" value="Delete" class="btn btn-orange w-100">  
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
                <div class="modal-title">Help</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-justify">
                <ul>
                    <li><p>Here we can see, modify, add and delete boards.</p></li>
                    <li><p>To add a board we have to click on <span class="text-secondary px-1"><i class="fas fa-plus-circle icono"></i>Add board</span> . Then we choose a picture, a name for the board and the size.</p></li>
                    <li><p>We can also look for a picture in the ARASAAC web page. We should write a word, download the one that suites best and upload it.</p></li>
                    <li><p>To modify a board we should click on <span class="btn-info px-1 md-3"><i class="fas fa-pen pr-md-2 icono"></i>Modify</span> and change all the information needed.</p></li>
                    <li><p>To delete a board we should click on <span class="btn-danger px-1 md-3"><i class="fas fa-minus pr-md-2 icono"></i>Delete</span> and the web will load again without the board we have chosen.</p></li>
                </ul> 
            </div>
        </div>
    </div>
</section>
    
</main>
@include('en/plantillas/footer')
@endsection
