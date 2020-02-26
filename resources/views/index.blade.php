@extends('plantillas/maestra')
@section('titulo')
Login
@endsection
@section('contenido')
    <header></header>
    <!-- MAIN -->
    <main class="d-flex">
        <section class="col-lg-4 col-md-5 col-sm-6 m-auto pt-5">
            <img src="{{asset('images/icons/logo_aspades.svg')}}" class="logo-login"/>
            <form action="comprobar" method="post">
                @csrf
                <div class="form-group">
                    <label class="sr-only" for="usuario">Usuario</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-user"></i></div>
                        </div>
                        <input type="text" name="usuario" id="usuario" placeholder="Usuario" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="clave">Contraseña</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                        </div>
                        <input type="password" name="clave" id="clave" placeholder="Contraseña" class="form-control">
                    </div>
                </div>
                <input type="submit" name="login" id="login" value="Iniciar sesión" class="btn btn-orange w-100">
            </form>
            <div id="mensaje" class="text-center pt-2 text-danger"><?php if (isset($mensaje)) { echo $mensaje; } ?></div>
        </section>
    </main>
@include('plantillas/footer')
@endsection
