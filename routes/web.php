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
    return view('CarlosYSusCosas/envio');
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
  |Administrador
  |--------------------------------------------------------------------------
 */

/**
 * Ruta para registrar un Usuario
 */
Route::post('registrar', 'ControladorAdmin@addUsuario')->name('gestionusuarios');

Route::group(['middleware' => 'Administrador'], function() {
    /**
     * Ruta para cargar los perfiles del pagination
     */
    Route::get('registrar', 'ControladorAdmin@crudUsuarios');
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
});

/*
  |--------------------------------------------------------------------------
  |Usuario
  |--------------------------------------------------------------------------
 */
Route::group(['middleware' => 'Usuario'], function() {
    /**
     * Redirige a la vista de inicio del usuario
     * @author Laura Mª Fernández Cambronero
     * @version 1.0
     */
    Route::get('iniciousuario', function () {
        return view('vistasusuario/iniciousuario');
    });
    /**
     * Ruta para obtener los Contextos del Usuario
     * Estaba con post
     */
    Route::any('obtenercontextos', 'ControladorUsuario@obtenerContextos');
    /**
     * Ruta para obtener los Subcontextos del Usuario
     * Estaba con post
     */
    Route::any('obtenersubcontextos', 'ControladorUsuario@obtenerSubcontextos');
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
    
    /**
     * Ruta para ir al tablero anterior
     * @author Victor
     */
     Route::post('modificarTablero', 'ControladorUsuario@modificarTablero');
     
     Route::post('eliminarTablero', 'ControladorUsuario@eliminarTablero');
     
     Route::any('addpagina','ControladorUsuario@addPagina');
     
     Route::any('eliminarpagina','ControladorUsuario@eliminarPagina');
     
     Route::any('vaciartablero','ControladorUsuario@DOOOOM');
     
     //Todos los any son responsabilidad de carlos, el resto de miembros del grupo saben como funciona un middleware.
});
