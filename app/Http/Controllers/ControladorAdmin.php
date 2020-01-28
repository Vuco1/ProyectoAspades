<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_Rol;

class ControladorPrueba extends Controller {

    function paginacion() {
        $users = Usuario::paginate(2);
        echo 'Hola';
        return view('pruebaPagination', ['usuarios' => $users]);
    }

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
            $datos = [
                'usuario' => $usuario,
                'rol' => $rol
            ];
            if ($rol == 1) {
                return view('envio', $datos);
            }
            if ($rol == 0) {
                return view('usuario', $datos);
            }
        }
    }

    public function eleccionCrudUsuario(Request $req) {

        if ($req->has('modUsuario')) {
            $this->modificarUsuario($req);
        }

        if ($req->has('eliminarUsuario')) {
            $this->eliminarUsuario($req);
        }

        $usuarios = \Session::get('datos');
        $datos = [
            'usuarios' => $usuarios,
        ];
        return view('CrudUsuarios', $datos);
    }

    public function addUsuario(Request $req) {
        $miusuario = \Session::get('usuario');

        $nick = $req->get('usuario');
        $clave = $req->get('clave');
        if ($req->has('rol')) {
            $rol = 1;
        } else {

            $rol = 0;
        }

        $usuario = new Usuario;
        $usuario->Nick = $nick;
        $usuario->Clave = $clave;
        $usuario->save();
        
        $usuarioadd = Persona::where('Nick', '=', $nick)->where('Clave', '=', $clave)->get();
        
        $usurol = new Usuario_Rol;
        $usurol->Id_rol = $rol;
        $usurol->Id_persona = $usuarioadd->Id_usuario;
        $usurol->save();
        
        $usuarios = Persona::where('Nick', '!=', $miusuario->Nick)->get();
        $datos = [
            'usuarios' => $usuarios,
        ];
        return view('crudUsuarios', $datos);
    }

}
