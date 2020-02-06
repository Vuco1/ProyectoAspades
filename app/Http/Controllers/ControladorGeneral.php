<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_Rol;
use App\Imagen;
use App\Tablero;
use App\Tablero_Imagen;

class ControladorGeneral extends Controller {

    /**
     * Login, se comprueba el nick y la clave introducida por el usuario y si es correcta o no.
     * @param Request $req Recibe los datos del formulario de registro.
     * @return $vista Ruta de la vista de destino.
     * @return $mensaje Notificación que se mostrará en el index en caso de error al iniciar sesión.
     */
    public function iniciarSesion(Request $req) {
        $nick = $req->get('usuario');
        $clave = md5($req->get('clave'));

        $usuario = Usuario::where('Nick', $nick)
                ->where('Clave', $clave)
                ->first();
        if ($usuario != null) {
            $usurol = Usuario_Rol::where('Id_usuario', $usuario->Id_usuario)->first();
            $rol = $usurol->Id_rol;
            switch ($rol) {
                case 0:
                    $tablero= Tablero::where('Id_usuario', $usuario->Id_usuario)->first();
                    $imagentablero= Tablero_Imagen::where('Id_tablero', $tablero->Id_tablero)->first();
                    $imgperfil= Imagen::where('Id_imagen', $imagentablero->Id_imagen)->first();
                    $vista = 'vistasusuario/iniciousuario';
                    
                    session()->put('imgperfil', $imgperfil);
                    session()->put('tablero', $tablero);
                    break;
                case 1:
                    $vista = 'vistasadmin/inicioadmin';
            }
            $mensaje = "";
            session()->put('usuario', $usuario);
            session()->put('rol', $rol);
        } else {
            $mensaje = "Error. Usuario o clave incorrectos";
            $vista = 'index';
        }

        return view($vista, ['mensaje' => $mensaje]);
    }

    /**
     * Cerrar sesion, elimina todos los elementos de la sesion actual y crea una nueva, 
     * devuelve al usuario a la pagina de login.
     * @return type Devuelve Login
     */
    public function cerrarSesion() {
        session()->invalidate();
        session()->regenerate();
        return view('index');
    }

}
