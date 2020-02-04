@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
    <!-- MAIN -->
    <main>
        <img src="{{asset("imagenes/Victor.jpg")}}" class="logo-login"/>
        <form action="comprobar" method="post">
            @csrf
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            <input type="password" name="clave" id="clave" placeholder="Clave">
            <input type="submit" name="login" id="login" value="Iniciar sesión">
        </form>
    </main>
@include('plantillas/footer')
@endsection
