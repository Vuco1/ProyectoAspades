@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
<header></header>
<main class="d-flex">
    <div class="m-auto">
        <h2>Acceso denegado.</h2> 
        <h3 class="mb-5">No tienes permisos para ver esta pagina</h3>
        <button class="btn btn-orange" onclick="volver()">Volver</button>
    </div>
</main>
@include('plantillas/footer')
@endsection
