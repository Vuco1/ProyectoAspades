<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Usuario_Rol;
use App\Models\Imagen;
use App\Models\Tablero;
use App\Models\Tablero_Imagen;

class ControladorGeneral extends Controller {

    /**
     * Login, se comprueba el nick y la clave introducida por el usuario y si es correcta o no.
     * En caso de que el rol sea usuario, se localiza el tablero principal de dicho usuario y se obtiene la
     * imagen de portada del mismo.
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
                    $vista = 'vistasusuario/iniciousuario';
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
