<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use lluminate\Pagination\Paginator;
//use lluminate\Pagination\LengthAwarePaginator;
use App\Usuario;
use App\Usuario_Rol;

class ControladorAdmin extends Controller {

    /**
     * Edita los datos de perfil del administrador. En caso de querer cambiar la 
     * contraseña no se requerirá la contraseña anterior.
     * @param Request $req Recibe los datos del formulario de registro.
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
            if ($clave != null) {
                $user->Clave = $clave;
            }
            $user->save();
        } catch (Exception $ex) {
            $mensaje = 'Error al modificar el perfil';
        }

        $user = Usuario::where('Id_usuario', $id)->first();
        \Session::put('usuario', $user);

        $datos = [
            'usuario' => $user,
            'mensaje' => $mensaje
        ];

        return view('vistasadmin/perfiladmin', $datos);
    }

    /**
     * Elimina a un usuario de la base de datos con la id de usuario.
     * @param Request $req Recibe los datos del formulario de registro.
     */
    public function eliminarUsuario($req) {
        $miusuario = \Session::get('usuario');
        $id = $req->get('Id');
        $usuario = Usuario::where('Id_usuario', $id)->first();
        $usuario->delete();
    }

    /**
     * Modifica los datos de un usuario concreto.
     * @param type $req Recibe los datos del formulario de registro.
     */
    public function modificarUsuario($req) {
        $usuario = Usuario::where('Id_usuario', $req->get('Id'))->first();
        $nick = $req->get('Nick');
        $nombre = $req->get('Nombre');
        $usuario->Nick = $nick;
        $usuario->Nombre = $nombre;
        $usuario->save();
//Discutir sobre la base de datos mañana
        $rol = Usuario_Rol::where('Id_usuario', $req->get('Id'))->first();

        $role = $req->Rol;
        $rol->Id_rol = $role;
        $rol->save();
    }

    /**
     * Registra un usuario nuevo.
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
        $usuario->Nombre = $nombre;
        $usuario->save();

        $usuarioadd = Usuario::where('Nick', '=', $nick)->where('Clave', '=', $clave)->first();

        $usurol = new Usuario_Rol;
        $usurol->Id_rol = $rol;
        $usurol->Id_usuario = $usuarioadd->Id_usuario;
        $usurol->save();

        $datos = self::selectUsuarios();
        $datos2 = self::selectRoles();
        return view('vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
    }

    /**
     * Devuelve el listado de usuarios para mostrar en el crud, los resultados aparecen paginados
     * @return LengthAwarePaginator
     */
    private function selectUsuarios() {
        $miusuario = \Session::get('usuario');
        $datos = \DB::table('usuarios')
                ->join('usuario_rol', 'usuarios.Id_usuario', '=', 'usuario_rol.Id_usuario')
                ->select('usuarios.*', 'usuario_rol.Id_rol')
                ->where('usuarios.Id_usuario', '!=', $miusuario->Id_usuario)
                ->paginate(5);
        return $datos;
    }

    /**
     * Devuelve la lista de los roles en la base de datos.
     * @return type
     */
    private function selectRoles() {
        $datos2 = \DB::Select('Select * from rol');
        return $datos2;
    }

    /**
     * Carga el crud de usuarios con la lista de usuarios y roles.
     * @return type
     */
    public function crudUsuarios() {
        $datos = self::selectUsuarios();
        $datos2 = self::selectRoles();
        return view('vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
    }

    /**
     * Recibe la opcion seleccionada en el crud (Modificar/Eliminar) y llama a la funcion correspondiente.
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
        $datos2 = self::selectRoles();
        return view('vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
    }

    /**
     * Llena la base de datos de usuarios random para testeo.
     */
    public function llenarBase() {
        for ($i = 0; $i < 20; $i++) {
            $nick = Str::random(10);
            $clave = md5(Str::random(10));
            $nombre = Str::random(10);
            $rol = 0;

            $usuario = new Usuario;
            $usuario->Nick = $nick;
            $usuario->Clave = $clave;
            $usuario->Nombre = $nombre;
            $usuario->save();

            $usuarioadd = Usuario::where('Nick', '=', $nick)->where('Clave', '=', $clave)->first();

            $usurol = new Usuario_Rol;
            $usurol->Id_rol = $rol;
            $usurol->Id_usuario = $usuarioadd->Id_usuario;
            $usurol->save();
        }
    }

}
