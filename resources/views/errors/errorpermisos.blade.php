@extends('plantillas/maestra')
@section('titulo')
@lang('messages.ErroresTitulo')
@endsection
@section('contenido')
<header></header>
<main class="d-flex">
    <div class="m-auto text-center">
        <h2>@lang('messages.ErroresH1')</h2> 
        <h3 class="mb-5">@lang('messages.ErroresParrafo')</h3>
        <button class="btn btn-orange" onclick="volver()">@lang('messages.ErroresBoton')</button>
    </div>
</main>
@include('plantillas/footer')
@endsection
