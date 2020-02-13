@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
<!-- HEADER -->
<header></header>
<!-- MAIN -->
<main class="d-flex pt-3">
    <?php $usuario = session()->get('usuario'); ?>        
    <form action="obtenercontextos" method="post" class="m-auto">
        @csrf
        <button class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        <h1>Hola <?php echo $usuario->Nick ?></h1>
    </form>
    <div id="mensaje" class="mt-3"><?php
        if (isset($mensaje)) {
            echo $mensaje;
        }
        ?></div>
    <!-- SCRIPTS -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
</main>
@include('plantillas/footer')
@endsection
