@extends('plantillas/maestra')
@section('titulo')
SubContextos
@endsection
@section('contenido')
<!-- HEADER -->
<header></header>
<!-- MAIN -->
<main class="d-flex pt-3">
    <div id="carouselSubcontextos" class="carousel slide m-auto px-5" data-ride="carousel" data-interval="false" data-touch="true">
        <div class="carousel-inner">
            <?php if (!$imgTablero) { ?>
                <p>Sin Resultados</p><?php
        } else {
            $cont = 0;
            $limite = 6;
            foreach ($imgTablero as $imgT) {
                if ($cont % $limite == 0) {
                    if ($cont == 0) {
                        echo '<div class="carousel-item active">';
                    } else {
                        echo '<div class="carousel-item">';
                    }
                }
                    ?>
                    <div class="card">
                        <form action="contextosUsuario" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $imgT->Id_imagen }}">
                            <button class="btn p-0 w-100">
                                <img src="{{ $imgT->Ruta }}" class="card-img-top img-contexto" alt="Imagen del contexto">
                                <div class="card-body p-2">
                                    <p class="card-text">{{ $imgT->Nombre }}</p>
                                </div>
                            </button>                
                        </form>
                    </div>
                    <?php
                    if (($cont + 1) % $limite == 0) {
                        echo '</div>';
                    }
                    $cont++;
                }
            }
            ?>
        </div>
    </div>
</main>
@endsection

