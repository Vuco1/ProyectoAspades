@extends('plantillas/maestra')
@section('titulo')
ContextosGenerales
@endsection
@section('contenido')
<main class="container-fluid">
    <nav id="menuoculto" class="navbar navbar-expand-md navbar-light bg-light p-0" style="display: none;">
        <a class="py-2 px-3" href="inicioadmin"><img src="{{ asset('images/logo_aspades.svg') }}" alt="Logo de Aspades la Laguna" class="logo-nav"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><div>
                        <button data-toggle="modal" data-target="#nuevo" class="btn btn-orange">Añadir Contexto</button>
                    </div></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users-cog icono"></i>Eliminar</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users-cog icono"></i>Modificar</a></li>
            </ul>
        </div>
    </nav>
    <input type="button" value="Ocultar" id="c1">
    <input type="button" value="Visualizar" id="c2">
    <?php if (!$imgtab) { ?>
        <p>Sin Resultados</p><?php
} else {
        ?>
        <div class="row contextodiv">
            <?php
            $cont = 1;
            foreach ($imgtab as $imgT) {
                if ($cont % 4 === 0) {
                    $cont = 1;
                    ?>
                </div>
                <div class="row contextodiv">
                    <?php
                }
                ?>
                <form action="contextosUsuario" method="post">
                    @csrf
                    <input type="hidden" name="id" value="<?= $imgT->Id_imagen ?>">
                    <button class="contextobtn"><img src="<?php echo $imgT->Ruta ?>" width="200" height="200"/></button>
                    <input type="hidden" name="contexto" value="<?= $imgT->Nombre ?>">
                </form>
                <?php
                $cont++;
            }
            ?>
        </div>
        <?php
    }
    ?>
    <section class="modal fade" id="nuevo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white px-4">
                    <div class="modal-title">Añadir Contexto</div>
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
                            </div>
                        </div> 
                        <input type="submit" name="guardar" id="guardar" value="Añadir" class="btn btn-orange w-100">  
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
