@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
<link rel="stylesheet" href="{{ asset('css/css_prueba.css') }}">
    <header></header>
    <main class="d-flex">
        <?php $usuario = session()->get('usuario'); ?>        
        <form action="iniciarContexto" method="post" class="centrado">
            @csrf
            <button class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        </form>

        <form action="cambiarFoto" method="post">
            @csrf
            <button class="btn btn-orange">Cambiar foto de perfil</button>
        </form>
        <div id="mensaje" class="mt-3"><?php if (isset($mensaje)) {
            echo $mensaje;
        } ?></div>
        <!-- SCRIPTS -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
    </main>
@include('plantillas/footer')
@endsection
