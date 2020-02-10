@extends('plantillas/maestra')
@section('titulo')
Contextos
@endsection
@section('contenido')
<main class="d-flex">
    <div id="carouselContextos" class="carousel slide m-auto" data-ride="carousel" data-interval="false" data-touch="true">
        <div class="carousel-inner">
        <?php
        $cont = 0;
        foreach ($contextos as $c) {
            if ($cont % 3 == 0) { //Cada 3 contextos se añade un item al carrousel
                if ($cont == 0) {
                    echo '<div class="carousel-item active">';
                } else {
                    echo '<div class="carousel-item">';
                }
                echo '<div class="card-deck">';
            } ?>
            <div class="card">
                <form action="contextosUsuario" method="post">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $c->Id_tablero; ?>">
                    <button class="btn">
                            <img src="<?php echo $c->Foto; ?>" class="card-img-top" alt="Imagen del contexto">
                            <div class="card-body p-2">
                                <p class="card-text"><?php echo $c->Nombre; ?></p>
                            </div>
                    </button>
                </form>
            </div>
            <?php if (($cont + 1) % 3 == 0) {
                    echo '</div>'
                    . '</div>';
                }
            $cont++;
        } ?>
        </div>
    </div>
</main>
@endsection