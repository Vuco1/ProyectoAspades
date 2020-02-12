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
Route::post('comprobar', 'ControladorGeneral@iniciarSesion');

Route::get('comprobar', function () {
    return view('index');
});
/**
 * Ruta paracerrar la Sesion
 */
Route::get('cerrarsesion', 'ControladorGeneral@cerrarSesion');


/*
  |--------------------------------------------------------------------------
  |Administardor
  |--------------------------------------------------------------------------
 */
Route::group(['middleware' => 'Administrador'], function() {
    /**
     * Ruta para registrar un Usuario
     * Estaba con Post
     */
    Route::any('registrar', 'ControladorAdmin@addUsuario')->name('gestionusuarios');
    /**
     * Ruta para 
     * Estaba con get
     */
    Route::any('registrar', 'ControladorAdmin@crudUsuarios');
    /**
     * Editar el perfil del administrador.
     * Post
     */
    Route::any('editarperfil', 'ControladorAdmin@editarPerfil');
    /**
     * Ruta para Modificar los Usuarios
     * Estaba con post
     */
    Route::any('updateUsuario', 'ControladorAdmin@updateUsuario');
    /**
     * Ruta para eliminar un Usuario
     * Estaba con post
     */
    Route::any('eliminarUsuario', 'ControladorAdmin@deleteUsuario');
    /**
     * Ruta que te lleva a la vista del inicio del Admin
     * Estaba con get
     */
    Route::any('inicioadmin', function () {
        return view('vistasadmin/inicioadmin', ['usuario' => session()->get('usuario')]);
    });
    /**
     * Ruta para ir al Perfil del Admin
     * Estaba con get
     */
    Route::any('perfil', function () {
        return view('vistasadmin/perfiladmin', ['usuario' => session()->get('usuario')]);
    });
    /**
     * Te lleva a la vista del Crud de Usuarios
     * Estaba con get
     */
    Route::any('gestionusuarios', 'ControladorAdmin@crudUsuarios');
    /**
     * LLena la BBDD con informacion random
     * Estaba con get
     */
    Route::any('kabum', 'ControladorAdmin@llenarBase');
    /**
     * Ruta para añadir un Usuario
     * Estaba con get
     */
    Route::any('addUsuario', function () {
        return view('vistasadmin/addusuario');
    });
});



/*
  |--------------------------------------------------------------------------
  |Usuario
  |--------------------------------------------------------------------------
 */
Route::group(['middleware' => 'Usuario'], function() {
    /**
     * Carga los subcontextos que tenga ese contexto
     * Estaba con post
     */
    Route::any('contextosUsuario', 'ControladorUsuario@contextosUsuario');
    /**
     * Estaba con get
     */
    Route::any('contextosusuario', 'ControladorUsuario@iniciarContexto');
    /**
     * Ruta para obtener los Contextos de el Usuario
     * Estaba con post
     */
    Route::any('obtenercontextos', 'ControladorUsuario@obtenerContextos');
    /**
     * Estaba con post
     */
    Route::any('subcontextosUsuario', 'ControladorUsuario@contextosUsuario');
    /**
     * Estaba con get
     */
    Route::any('addContexto', function () {
        return view('vistasusuario/addcontexto');
    });
    /**
     * 
     * Estaba con post
     */
    Route::any('modificacionContextos', 'ControladorUsuario@eleccionFuncion');
    /**
     * Ruta para subir un Tablero
     * Estaba con post
     */
    Route::any('subirTablero', 'ControladorUsuario@subirTablero');
    /**
     * 
     * Estaba con post
     */
    Route::any('vistaimagen', function () {
        return view('vistasusuario/vistaimagen');
    });
    /**
     * Ruta para volver al perfil del Usuario
     * Estaba con get
     */
    Route::any('perfilusuario', function () {
        return view('vistasusuario/perfilusuario');
    });
});
