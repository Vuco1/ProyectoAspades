<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Login');
});

/**
 * Del index a una pagina de Prueba para probar el pagination
 */
//Route::get('pagination','ControladorPrueba@paginacion');

/**
 * Del index a una pagina de Prueba para probar el delay del speech y el submit
 */
Route::post('prueba', function () {
    return view('envio');
});

/**
 * Ruta para saber si eres admin o Usuario o si no existes
 */
Route::post('comprobar','ControladorPrueba@comprobarUsuario');

/**
 * Ruta para registrar un Usuario
 */
Route::post('registrar','ControladorAdmin@registrarUsuario');

/**
 * Editar el perfil del administrador.
 */
Route::post('editar_perfil','ControladorPrueba@editarPerfil');
