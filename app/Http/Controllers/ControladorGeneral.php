<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_Rol;

class ControladorGeneral extends Controller {

    /**
     * Login, se comprueba el nick y la clave introducida por el usuario y si es correcta o no.
     * @param Request $req Recibe los datos del formulario de registro.
     * @return type
     */
    public function comprobarUsuario(Request $req) {
        $nick = $req->get('usuario');
        $clave = $req->get('clave');
        $claveCod = md5($clave);
        $usuario = Usuario::where('Nick', $nick)
                ->where('Clave', $claveCod)
                ->first();
        if ($usuario == null) {
            return view('error');
        } else {
            $usurol = Usuario_Rol::where('Id_usuario', $usuario->Id_usuario)->first();
            $rol = $usurol->Id_rol;
            session()->put('usuario', $usuario);
            session()->put('rol', $usurol);
//            \Session::put('usuario', $usuario);
//            \Session::put('rol', $usurol);
            
//            $usuarios = Usuario::where('Id_usuario', '!=', $usuario2->Id_usuario)->get();
//            foreach ($usuarios as $usu) {
//                $rol2= Usuario_Rol::where('Id_usuario', $usu->Id_usuario)->first();
//                $datos[] = [
//                    'id' => $usu->Id_usuario,
//                    'nick' => $usu->Nick,
//                    'nombre' => $usu->Nombre,
//                    'rol' => $rol2->Id_rol
//                ];
//            }
            $datos2 = [
                'datos' => $usuario
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
     * Cerrar sesion, elimina todos los elementos de la sesion actual y crea una nueva, 
     * devuelve al usuario a la pagina de login.
     * @return type Devuelve Login
     */
     public function cerrarSesion() {
        \Session::invalidate();
        \Session::regenerate();
        return view('index');
    }

}
