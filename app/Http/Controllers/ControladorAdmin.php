<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use lluminate\Pagination\Paginator;
use Illuminate\Support\Str;
//use lluminate\Pagination\LengthAwarePaginator;
use App\Models\Usuario;
use App\Models\Usuario_Rol;

class ControladorAdmin extends Controller {

    /**
     * Edita los datos de perfil del administrador.
     * @param Request $req Recibe los datos del formulario del perfil.
     */
    public function editarPerfil(Request $req) {
        $id = $req->get('id');
        $nick = $req->get('usuario');
        $nombre = $req->get('nombre');
        $clave = $req->get('clave');
        $req->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imagen = $req->file('imagen');

        $mensaje = 'Perfil modificado con éxito';
        try {
            $usuario = Usuario::where('Id_usuario', $id)->first();
            $usuario->Nombre = $nombre;
            $usuario->Nick = $nick;

            if ($clave != null) {
                $clave = md5($req->get('clave'));
                $usuario->Clave = $clave;
            }
            if ($imagen != null) {
                $nomimagen = $imagen->getClientOriginalName();
                $usuario->Foto = 'images/users/' . $nomimagen;
                $req->imagen->move(public_path('images/users'), $nomimagen);
            }
            $usuario->save();
        } catch (Exception $ex) {
            $mensaje = 'Error al modificar el perfil';
        }

        $usuario = Usuario::where('Id_usuario', $id)->first();
        session()->put('usuario', $usuario);

        $datos = [
            'usuario' => $usuario,
            'mensaje' => $mensaje
        ];

        return view('vistasadmin/perfiladmin', $datos);
    }

    /**
     * Registra un usuario nuevo.
     * @param Request $req Recibe los datos del formulario de registro.
     * @return Lista de usuarios despues de haber realizado la insercion del usuario nuevo.
     */
    public function addUsuario(Request $req) {
        $miusuario = session()->get('usuario');

        $nick = $req->get('usuario');
        $clave = md5($req->get('clave'));
        $nombre = $req->get('nombre');
        if ($req->file('imagen')) {
            $req->validate([
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $foto = $req->file('imagen');
            $nomimagen = $foto->getClientOriginalName();
            $req->imagen->move(public_path('images/users/'), $nomimagen);
        } else {
            $nomimagen = 'general.jpg';
        }

        if ($req->has('rol')) {
            $rol = 1;
        } else {
            $rol = 0;
        }
        $usuario = new Usuario;
        $usuario->Nick = $nick;
        $usuario->Clave = $clave;
        $usuario->Nombre = $nombre;
        $usuario->Foto = 'images/users/' . $nomimagen;
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
                ->orderBy('Nombre', 'ASC')
                ->paginate(4);
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

    /**
     * Modifica los datos de un usuario de la BBDD teniendo en cuenta su id único.
     * @param Request $request
     */
    public function updateUsuario(Request $request) {
        $nombre = $request->input('nombre');
        $nick = $request->input('nick');
        $id = $request->input('id');
        $role = $request->input('rol');
        $usuario = Usuario::where('Id_usuario', $id)->first();
        $usuario->Nick = $nick;
        $usuario->Nombre = $nombre;

        $usuario->save();

        $rol = Usuario_Rol::where('Id_usuario', $id)->first();
        $rol->Id_rol = $role;
        $rol->save();

        exit;
    }

    /**
     * Borra los datos de un usuario de la BBDD teniendo en cuenta su id único.
     * @param Request $request
     */
    public function deleteUsuario(Request $request) {
        $id = $request->input('id');
        $usuario = Usuario::where('Id_usuario', $id)->delete();
        exit;
    }

}
