@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
    <main>
        <p>Error No tienes los permisos para acceder a esta pagina</p>
        <button onclick="volver()">Volver</button>
    </main>
@include('plantillas/footer')
@endsection
