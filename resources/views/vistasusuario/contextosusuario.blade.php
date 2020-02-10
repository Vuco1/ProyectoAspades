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
                            <img src="<?php echo $c->Foto; ?>" class="card-img-top" alt="Imagen del tablero">
                            <div class="card-body">
                                <p class="card-text">Tablero 1</p>
                            </div>
                        </div>
                    </form>
        <?php } ?>

                





                    
                </div>

                <div class="carousel-item">
                    <div class="card-group">
                        <div class="card">
                            <img src="images/aryan-dhiman-iGLLtLINSkw-unsplash.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Tablero 1</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/gratisography-laptop-colorful-keys.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Tablero 2</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/img1.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Tablero 3</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item" >
                    <div class="card-group">
                        <div class="card">
                            <img src="images/img2.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Tablero 1</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/img3.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Tablero 2</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/aryan-dhiman-iGLLtLINSkw-unsplash.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Tablero 3</p>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                $cont--;
            }
            ?>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection