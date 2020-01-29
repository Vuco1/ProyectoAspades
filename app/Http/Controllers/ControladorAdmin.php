<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_Rol;

class ControladorPrueba extends Controller {

    /**
      function paginacion() {
      $users = Usuario::paginate(2);
      echo 'Hola';
      return view('pruebaPagination', ['usuarios' => $users]);
      }
      /**


      /**
     * Funcion que recibe la opcion seleccionada en el crud (Modificar/Eliminar) y llama a la funcion correspondiente.
     * @param Request $req Recibe los datos del usuario sobre el que se desee que se realicen los cambios.
     * @return type
     */
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

    /**
     * Funcion para registrar un usuario nuevo.
     * @param Request $req Recibe los datos del formulario de registro.
     * @return Lista de usuarios despues de haber realizado la insercion del usuario nuevo.
     */
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

        $usuarioadd = Usuario::where('Nick',$nick)->get();

        $usurol = new Usuario_Rol;
        $usurol->Id_rol = $rol;
        $usurol->Id_usuario = $usuarioadd->Id_usuario;
        $usurol->save();

        $datos = self::selectUsuarios();
        return view('crudUsuarios', $datos);
    }

    public function eliminarUsuario($req) {
        $miusuario = \Session::get('usuario');
        $usuario = $req->get('id');
        Usuario::where('Id_usuario', $matricula)->delete();
        $usuarios = Usuario::where('Id_usuario', '!=', $miusuario->Id_usuario)->get();
        $datos = self::selectUsuarios();
        return view('crudUsuarios', $datos);
    }

    public function modificarUsuario($req) {
        $usuario = Usuario::where('Id_usuario', $req->get('id'))->first();
        $nick = $req->get('Nick');
        $usuario->Nick = $nick;
        $usuario->save();
        //Discutir sobre la base de datos mañana
        $rol = Usuario_Rol::where('Id_usuario', $req->get('id'))->first();
        $role = $req->get('Id_rol');
        $rol->Id_rol = $role;
        $rol->save();
        $datos = self::selectUsuarios();
        return view('crudUsuarios', $datos);
    }

    private function selectUsuarios() {
        $miusuario = \Session::get('usuario');
        $usuarios = Usuario::where('Id_usuario', '!=', $miusuario->Id_usuario)->get();
        $datos = [];
        foreach ($usuarios as $usu) {
            $datos[] = [
                'id' => $usu->Id_usuario,
                'nick' => $usu->Nick,
                'nombre' => $usu->Nombre,
                'rol' => Usuario_Rol::where('Id_usuario', $usu->Id_usuario)
            ];
        }
        return $datos;
    }

}
