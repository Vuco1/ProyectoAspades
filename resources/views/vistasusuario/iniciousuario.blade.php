@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
    <header></header>
    <main class="d-flex">
        <?php $usuario = session()->get('usuario'); ?>        
        <form action="iniciarContexto" method="post">
            @csrf
            <button><img src="<?php echo $usuario->Foto ?>" width="500" height="500"/></button>
        </form>

        <form action="cambiarFoto" method="post">
            @csrf
            <button>Cambiar foto de perfil</button>
        </form>
        <div id="mensaje" class="mt-3"><?php if (isset($mensaje)) {
            echo $mensaje;
        } ?></div>
        <!-- SCRIPTS -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
    </main>
@include('plantillas/footer')
@endsection