@extends('plantillas/maestra')
@section('titulo')
Contextos
@endsection
@section('contenido')
<!-- HEADER -->
<header></header>
<!-- MAIN -->
<main class="d-flex pt-3">
    <div id="carouselContextos" class="carousel slide m-auto px-5" data-ride="carousel" data-interval="false" data-touch="true">
        <div class="carousel-inner">
            <?php if (!$contextos) { ?>
                <h1>Sin Resultados</h1><?php
            } else {
                $cont = 0;
                foreach ($contextos as $imgT) {
                    if ($cont % 6 == 0) { //Cada 3 contextos se añade un item al carrousel
                        if ($cont == 0) {
                            echo '<div class="carousel-item active">';
                        } else {
                            echo '<div class="carousel-item">';
                        }
                        echo '<div class="card-deck">';
                    }
                    ?>
                    <div class="card">
                        <form action="obtenersubcontextos" method="post">
                            @csrf
                            <input type="hidden" name="puntero" value="{{ $imgT->Id_imagen }}">
                            <button class="btn p-0 w-100">
                                <img id="img{{ $imgT->Id_imagen }}" src="{{ $imgT->Ruta }}" class="card-img-top img-contexto" alt="Imagen del contexto">
                                <div class="card-body p-2">
                                    <input type="hidden" name="nombre" value="{{ $imgT->Nombre }}" id="nombre{{ $imgT->Id_imagen }}">
                                    <p class="card-text">{{ $imgT->Nombre }}</p>
                                </div>
                            </button>                
                        </form>
                    </div>
                    <?php
                    if (($cont + 1) % 6 == 0) {
                        echo '</div>'
                        . '</div>';
                    }
                    $cont++;
                }
            }
            ?>
        </div>
    </div>
</main>
@endsection
