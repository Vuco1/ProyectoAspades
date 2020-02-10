@extends('plantillas/maestra')
@section('titulo')
ContextosGenerales
@endsection
@section('contenido')
<main class="container-fluid">
    <div>
        <img src="{{ asset('images/construccion.jpg') }}" alt="Imagen 1" width="400rem" style="float: left;"/>
    </div>
    
    <div>
        <img src="{{ asset('images/construccion.jpg') }}" alt="Imagen 2" width="400rem" style="float: right;"/>
    </div>
    
    <div>
        <img src="{{ asset('images/construccion.jpg') }}" alt="Imagen 2" width="400rem" style="position: fixed; bottom: 0; left: 0;"/>
    </div>
    
    <div>
        <img src="{{ asset('images/construccion.jpg') }}" alt="Imagen 2" width="400rem" style="position: fixed; bottom: 0;right:0;  "/>
    </div>
</main>
@endsection