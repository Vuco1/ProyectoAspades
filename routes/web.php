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
})->middleware(['Sesion','Temas']); 
/*
  |--------------------------------------------------------------------------
  | PRUEBAS/TESTING
  |--------------------------------------------------------------------------
 */

Route::group(['middleware' => 'Idioma'], function () {

Route::get('comprobar', function () {
    return view('index');
});

/**
 * Ruta para obtener el logo a cargar
 */
Route::get('rutalogo', 'ControladorGeneral@rutaLogo');

/**
 * Ruta paracerrar la Sesion
 */
Route::get('cerrarsesion', 'ControladorGeneral@cerrarSesion');

    Route::get('lang/{lang}', function ($lang) {
        session()->flush();
        session()->put('lang', $lang);
        $langu = session()->get('lang');
        return \Redirect::back();
    })->where([
        'lang' => 'en|es'
    ]);

//Pruebas para el Localization
//Route::get('/', 'LocalizationControlador@index')->middleware('Sesion');
//Route::get('/{locale}', function ($locale) {
//    if (in_array($locale, ['en', 'es', 'fr'])) {        
//        \App::setLocale($locale);
//    }
//    return view('index');
//});
    /*
      |--------------------------------------------------------------------------
      | PRUEBAS/TESTING
      |--------------------------------------------------------------------------
     */

    /*
      |--------------------------------------------------------------------------
      |GENERALES
      |--------------------------------------------------------------------------
     */
    /**
     * Ruta para saber si eres admin o Usuario o si no existes
     */
    Route::any('editarperfil', 'ControladorAdmin@editarPerfil');
    /**
     * Ruta para Modificar los Usuarios
     * Estaba con post
     */
    Route::post('updateusuario', 'ControladorAdmin@updateUsuario');
    Route::get('updateusuario', 'ControladorAdmin@crudUsuarios');
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
     * Ruta paracerrar la Sesion
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
    
    Route::get('personalizar', function () {
    return view('vistasadmin/personalizar');
});

Route::post('personalizarweb', 'ControladorAdmin@personalizarweb');

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
        Route::post('updateusuario', 'ControladorAdmin@updateUsuario');
        Route::get('updateusuario', 'ControladorAdmin@crudUsuarios');
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
         * Editar el perfil del usuario.
         * Post
         */
        Route::any('editarperfilusuario', 'ControladorUsuario@editarPerfilUsuario');
        /**
         * Ruta para obtener los Subcontextos del Usuario
         * Estaba con post
         */
        Route::post('obtenersubcontextos', 'ControladorUsuario@obtenerSubcontextos');
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
        Route::post('modificacionContextos', 'ControladorUsuario@eleccionFuncion');
        /**
         * Ruta para subir un Tablero
         * Estaba con post
         */
        Route::post('subirTablero', 'ControladorUsuario@subirTablero');
        /**
         * 
         * Estaba con post
         */
        Route::post('vistaimagen', function () {
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

        Route::post('addpagina', 'ControladorUsuario@addPagina');

        Route::post('eliminarpagina', 'ControladorUsuario@eliminarPagina');

        Route::post('vaciartablero', 'ControladorUsuario@DOOOOM');
    });



    Route::group(['middleware' => 'RutasGet'], function() {
        /**
         * Ruta para obtener los Subcontextos del Usuario
         * Estaba con post
         */
        Route::get('obtenersubcontextos', 'ControladorUsuario@obtenerSubcontextos');
        /**
         * 
         * Estaba con post
         */
        Route::get('modificacionContextos', 'ControladorUsuario@eleccionFuncion');
        /**
         * Ruta para subir un Tablero
         * Estaba con post
         */
        Route::get('subirTablero', 'ControladorUsuario@subirTablero');

        /**
         * Ruta para ir al tablero anterior
         * @author Victor
         */
        Route::get('modificarTablero', 'ControladorUsuario@modificarTablero');

        Route::get('eliminarTablero', 'ControladorUsuario@eliminarTablero');

        Route::get('addpagina', 'ControladorUsuario@addPagina');

        Route::get('eliminarpagina', 'ControladorUsuario@eliminarPagina');

        Route::get('vaciartablero', 'ControladorUsuario@DOOOOM');
    });
});
