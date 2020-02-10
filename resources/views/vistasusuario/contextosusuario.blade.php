@extends('plantillas/maestra')
@section('titulo')
Contextos
@endsection
@section('contenido')
<main class="container-fluid">
    <div id="carouselContextos" class="carousel slide" data-ride="carousel" data-interval="false" data-touch="true">
        <div class="carousel-inner">
        <?php
        $active = true; //Marca el primer carrousel-item
        $cont = 0; //Número de contextos por página del carrousel
        if ($cont % 3 == 0) {
            if ($active == true) { ?>
            <div class="carousel-item active">
            <?php 
                $active = false;
            } else { ?>
            <div class="carousel-item">
            <?php } ?>
                <div class="card-group">
                <?php foreach ($contextos as $c) { ?>
                    <form action="contextosUsuario" method="post">
                        @csrf
                        <input type="hidden" name="id" value="<?php echo $c->Id_tablero; ?>">
                        <button>
                            <div class="card">
                                <img src="<?php echo $c->Foto; ?>" class="card-img-top" alt="Imagen del contexto">
                                <div class="card-body">
                                    <p class="card-text"><?php echo $c->Nombre; ?></p>
                                </div>
                            </div>
                        </button>
                    </form>
                <?php
                    $cont++;
                }
                ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</main>
@endsection