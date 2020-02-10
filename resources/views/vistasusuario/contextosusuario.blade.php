@extends('plantillas/maestra')
@section('titulo')
Contextos
@endsection
@section('contenido')
<main class="container-fluid">
    <div id="carouselContextos" class="carousel slide" data-ride="carousel" data-interval="false" data-touch="true">
        <div class="carousel-inner">
        <?php
        $inicio = true;
        $cont = 3; //Número de contextos por página del carrousel
        if ($inicio == true) { ?>
            <div class="carousel-item active">
        <?php 
            $inicio = false;
        } else { ?>
            <div class="carousel-item">
        <?php } ?>
                <div class="card-group">
        <?php foreach ($contextos as $c) { ?>
                    <form action="contextosUsuario" method="post">
                        @csrf
                        <div class="card">
                            <img src="<?php echo $c->Foto; ?>" class="card-img-top" alt="Imagen del contexto">
                            <div class="card-body">
                                <p class="card-text"><?php echo $c->Nombre; ?></p>
                            </div>
                        </div>
                    </form>
        <?php $cont--; } ?>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection