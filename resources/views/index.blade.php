@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
    <header></header>
    <!-- MAIN -->
    <main>
        <img src="{{asset('images/logo_aspades.svg')}}" class="logo-login"/>
        <form action="comprobar" method="post">
            @csrf
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            <input type="password" name="clave" id="clave" placeholder="Clave">
            <input type="submit" name="login" id="login" value="Iniciar sesión">
        </form>
        <div id="mensaje"><?php if (isset($mensaje)) { echo $mensaje; } ?></div>
    </main>
@include('plantillas/footer')
@endsection
