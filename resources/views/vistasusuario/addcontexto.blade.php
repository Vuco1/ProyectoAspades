@extends('plantillas/maestra')
@section('titulo')
ContextosGenerales
@endsection
@section('contenido')
<main class="container-fluid">
    <div class="row contextodiv">

        <form action="subirTablero" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <input type="file" name="image" class="form-control">
                </div>
                 <div class="col-md-6">
                    <input type="text" name="nombre" class="form-control">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Subir</button>
                </div>
            </div>
        </form>

    </div>
</main>
@endsection