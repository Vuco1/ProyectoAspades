@extends('plantillas/maestra')
@section('titulo')
InicioUsuario
@endsection
@section('contenido')
<main class="d-flex">
    <?php $usuario = session()->get('usuario'); ?>        
    <form action="obtenercontextos" method="post">
        @csrf
        <button class="btn btn-orange rounded-circle p-3"><img src="<?php echo $usuario->Foto; ?>" class="img-perfil rounded-circle"/></button>
        <h1>Hola <?php echo $usuario->Nick ?></h1>
    </form>
</main>
@endsection