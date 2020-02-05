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
//        $usuario = $req->get('usuario');
//        $clave = $req->get('clave');
//        $clave2 = md5($clave);
        $usuario = 'admin';
        $clave2=md5('admin');
        $usuario2 = Usuario::where('Nick', $usuario)
                ->where('Clave', $clave2)
                ->first();
        if ($usuario2 == null) {
            return view('error');
        } else {
            $usurol = Usuario_Rol::where('Id_usuario', $usuario2->Id_usuario)->first();
            $rol = $usurol->Id_rol;
            \Session::put('usuario', $usuario2);
            \Session::put('rol', $usurol);
            
            $usuarios = Usuario::where('Id_usuario', '!=', $usuario2->Id_usuario)->get();
            foreach ($usuarios as $usu) {
                $rol2= Usuario_Rol::where('Id_usuario', $usu->Id_usuario)->first();
                $datos[] = [
                    'id' => $usu->Id_usuario,
                    'nick' => $usu->Nick,
                    'nombre' => $usu->Nombre,
                    'rol' => $rol2->Id_rol
                ];
            }
            $datos2 = [
                'datos' => $datos
            ];
            if ($rol == 1) {
                return view('vistasadmin/inicioadmin',$datos2);
            }
            if ($rol == 0) {
                return view('vistasusuario/usuario',$datos2);
            }
        }
    }
    /**
     * Funcion de Cerrar sesion, elimina todos los elementos de la sesion actual y crea una nueva, devuelve al usuario a la pagina de login.
     * @return type Devuelve Login
     */
     public function cerrarSesion() {
        \Session::invalidate();
        \Session::regenerate();
        return view('index');
    }

}
