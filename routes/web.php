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
    return view('index');
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
Route::post('comprobar','ControladorGeneral@iniciarSesion');

/**
 * Ruta para registrar un Usuario
 */
Route::post('registrar','ControladorAdmin@addUsuario');

/**
 * Editar el perfil del administrador.
 */
Route::post('editarperfil','ControladorAdmin@editarPerfil');

Route::post('updateUsuario','ControladorAdmin@updateUsuario');

Route::post('eliminarUsuario','ControladorAdmin@deleteUsuario');

Route::post('iniciarContexto','ControladorUsuario@iniciarContextos');


Route::any('crudUsu', 'ControladorAdmin@eleccionCrud');

Route::get('inicioadmin', function () {
    return view('vistasadmin/inicioadmin',['usuario'=>session()->get('usuario')]);
});

Route::get('perfil', function () {
    return view('vistasadmin/perfiladmin',['usuario'=>session()->get('usuario')]);
});

Route::get('gestionusuarios', 'ControladorAdmin@crudUsuarios');

Route::get('cerrarsesion', 'ControladorGeneral@cerrarSesion');

Route::get('kabum', 'ControladorAdmin@llenarBase');

Route::get('addUsuario', function () {
    return view('vistasadmin/addusuario');
});

Route::post('contextosUsuario','ControladorUsuario@contextosUsuario');

Route::post('subcontextosUsuario', function () {
    return view('vistasusuario/trabajando');
});
