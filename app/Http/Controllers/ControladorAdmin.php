<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_Rol;

class ControladorAdmin extends Controller {

    /**
      function paginacion() {
      $users = Usuario::paginate(2);
      echo 'Hola';
      return view('pruebaPagination', ['usuarios' => $users]);
      }
      /**

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
                return view('VistasAdmin/InicioAdmin', $datos);
            }
            if ($rol == 0) {
                return view('usuario', $datos);
            }
        }
    }

      /**
     * Funcion que recibe la opcion seleccionada en el crud (Modificar/Eliminar) y llama a la funcion correspondiente.
     * @param Request $req Recibe los datos del usuario sobre el que se desee que se realicen los cambios.
     * @return type
     */
    public function eleccionCrud(Request $req) {

        if ($req->has('modUsuario')) {
            $this->modificarUsuario($req);
        }

        if ($req->has('eliminarUsuario')) {
            $this->eliminarUsuario($req);
        }

       $datos = self::selectUsuarios();
        return view('vistasadmin/crudusuario', $datos);
    }

    /**
     * Funcion para registrar un usuario nuevo.
     * @param Request $req Recibe los datos del formulario de registro.
     * @return Lista de usuarios despues de haber realizado la insercion del usuario nuevo.
     */
    public function addUsuario(Request $req) {
        $miusuario = \Session::get('usuario');

        $nick = $req->get('usuario');
        $clave = md5($req->get('clave'));
        $nombre = $req->get('nombre');
        if ($req->has('rol')) {
            $rol = 1;
        } else {

            $rol = 0;
        }

        $usuario = new Usuario;
        $usuario->Nick = $nick;
        $usuario->Clave = $clave;
        $usuario->Nombre=$nombre;
        $usuario->save();

        $usuarioadd = Usuario::where('Nick', '=', $nick)->where('Clave', '=', $clave)->first();
        
        $usurol = new Usuario_Rol;
        $usurol->Id_rol = $rol;
        $usurol->Id_usuario = $usuarioadd->Id_usuario;
        $usurol->save();

        $datos = self::selectUsuarios();
        return view('vistasadmin/crudusuario', $datos);
    }
    
    /**
     * Edita los datos de perfil del administrador. En caso de querer cambiar la 
     * contraseña no se requerirá la contraseña anterior.
     * @param Request $req
     */
    public function editarPerfil(Request $req) {
        $id = $req->get('id');
        $nick = $req->get('nick');
        $nombre = $req->get('nombre');
        $clave = $req->get('clave');
        
        $mensaje = 'Perfil modificado con éxito';
            try {
                $user = Usuario::where('Id_usuario', $id)->first();
                $user->Nombre = $nombre;
                $user->Nick = $nick;
                if ($clave != null){
                    $user->Clave = $clave;
                }
                $user->save();
            } catch (Exception $ex) {
                $mensaje = 'Error al modificar el perfil';
            }
            
            $user = Usuario::where('Id_usuario', $id)->first();
            
            $datos = [
            'usuario' => $user,
            'mensaje' => $mensaje
        ];

        return view('vistasadmin//perfiladmin', $datos);
    }

    public function eliminarUsuario($req) {
        $miusuario = \Session::get('usuario');
        $id = $req->get('Id');
        $usuario = Usuario::where('Id_usuario', $id)->first();
        $usuario->delete();
    }

    public function modificarUsuario($req) {
        $usuario = Usuario::where('Id_usuario', $req->get('Id'))->first();
        $nick = $req->get('Nick');
        $nombre = $req->get('Nombre');
        $usuario->Nick = $nick;
        $usuario->Nombre = $nombre;
        $usuario->save();
//Discutir sobre la base de datos mañana
        $rol = Usuario_Rol::where('Id_usuario', $req->get('Id'))->first();
        if ($req->has('Rol')) {
            $role=1;
        } else {
            $role=0;
        }
        $rol->Id_rol = $role;
        $rol->save();
    }

    private function selectUsuarios() {
        $miusuario = \Session::get('usuario');
        $users = Usuario::where('Id_usuario', '!=', $miusuario->Id_usuario)->get();
        foreach ($users as $usu) {
            $rol = Usuario_Rol::where('Id_usuario', $usu->Id_usuario)->first();
            $usuarios[] = [
                'id' => $usu->Id_usuario,
                'nick' => $usu->Nick,
                'nombre' => $usu->Nombre,
                'rol' => $rol->Id_rol
            ];
        }
        $datos = [
            'datos' => $usuarios
        ];
        return $datos;
    }

    public function cerrarSesion () {
        \Session::invalidate();
        \Session::regenerate();
        return view('index');
    }

    public function crudUsuarios () {
        $datos = self::selectUsuarios();
        return view('vistasadmin/crudusuario', $datos);
    }
}
