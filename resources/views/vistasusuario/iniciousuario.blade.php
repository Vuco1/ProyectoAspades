@extends('plantillas/maestra')
@section('titulo')
InicioUsuario
@endsection
@section('contenido')
<main class="d-flex">
    <?php $fotoPerfil = session()->get('imgperfil'); ?>        
    <form action="iniciarContexto" method="post">
        @csrf
        <button class="contextobtn"><img src="<?php echo $fotoPerfil->Ruta ?>" width="500" height="500"/></button>
    </form>
</main>
@endsection