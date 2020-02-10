@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
    <header></header>
    <main class="d-flex">
        <form action="modificarFoto" method="post" enctype="multipart/form-data">
            @csrf
            <label for="imagen">Imagen </label> 
            <input id="imagen" name="imagen" size="30" type="file" class="form-control-file"/>
            <input type="submit" name="aceptar" value="Aceptar" />
        </form>
        <!-- SCRIPTS -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->        
    </main>
@include('plantillas/footer')
@endsection