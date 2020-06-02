@extends('plantillas/maestra')
@section('titulo')
@lang('messages.TituloError')
@endsection
@section('contenido')
<header></header>
<main class="d-flex">
    <div class="m-auto text-center">
        <h2>@lang('messages.ErrorH2')</h2> 
        <h3 class="mb-5">@lang('messages.ErrorH3')</h3>
        <button class="btn btn-orange" onclick="volver()">@lang('messages.ErrorBoton')</button>
    </div>
</main>
@include('plantillas/footer')
@endsection
