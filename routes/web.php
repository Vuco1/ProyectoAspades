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
/*
|--------------------------------------------------------------------------
| PRUEBAS/TESTING
|--------------------------------------------------------------------------
 */

/**
 * Del index a una pagina de Prueba para probar el delay del speech y el submit
 */
Route::post('prueba', function () {
    return view('envio');
});
/*
|--------------------------------------------------------------------------
|GENERALES
|--------------------------------------------------------------------------
 */
/**
 * Ruta para saber si eres admin o Usuario o si no existes
 */
Route::post('comprobar','ControladorGeneral@iniciarSesion');

/**
 * Ruta para registrar un Usuario
 */
Route::post('registrar','ControladorAdmin@addUsuario')->name('gestionusuarios');

Route::get('registrar','ControladorAdmin@crudUsuarios');
/**
 * Editar el perfil del administrador.
 */
Route::post('editarperfil','ControladorAdmin@editarPerfil');

Route::post('updateUsuario','ControladorAdmin@updateUsuario');

Route::post('eliminarUsuario','ControladorAdmin@deleteUsuario');

Route::post('obtenercontextos','ControladorUsuario@obtenerContextos');


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

Route::get('contextosusuario', 'ControladorUsuario@iniciarContexto');

Route::post('subcontextosUsuario', 'ControladorUsuario@contextosUsuario');

Route::get('addContexto', function () {
    return view('vistasusuario/addcontexto');
});

Route::post('modificacionContextos','ControladorUsuario@eleccionFuncion');

Route::post('subirTablero', 'ControladorUsuario@subirTablero');

Route::post('vistaimagen', function () {
    return view('vistasusuario/vistaimagen');
});

Route::get('perfilusuario', function () {
    return view('vistasusuario/perfilusuario');
});
