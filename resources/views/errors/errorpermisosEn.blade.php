@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
<header></header>
<main class="d-flex">
    <div class="m-auto text-center">
        <h2>Acceso denegado</h2> 
        <h3 class="mb-5">You don´t have permissions to view this page.</h3>
        <button class="btn btn-orange" onclick="volver()">Volver</button>
    </div>
</main>
@include('plantillas/footer')
@endsection
