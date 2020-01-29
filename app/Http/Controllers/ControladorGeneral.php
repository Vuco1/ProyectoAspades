<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_Rol;

class ControladorGeneral extends Controller {

    /**
     * Funcion de Login, se comprueba el nick y la clave introducida por el usuario y si es correcta
     * @param Request $req
     * @return type
     */
    function comprobarUsuario(Request $req) {
        $usuario = $req->get('usuario');
        $clave = $req->get('clave');
        //$clave = md5($clave);
        $usuario = Usuario::where('Nick', $usuario)
                ->where('Clave', $clave)
                ->first();
        if ($usuario == null) {
            return view('error');
        } else {
            $usurol = Usuario_Rol::where('Id_usuario', $usuario->Id_usuario)->first();
            $rol = $usurol->Id_rol;
            \Session::put('usuario', $usuario);
            \Session::put('rol', $usurol);
            if ($rol == 1) {
                return view('InicioAdmin', $datos);
            }
            if ($rol == 0) {
                return view('usuario', $datos);
            }
        }
    }

}
