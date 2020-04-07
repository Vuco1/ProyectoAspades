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
     * @author Isabel y Laura
     */
    public function editarPerfil(Request $req) {
        $id = $req->get('id');
        $nick = $req->get('usuario');
        $nombre = $req->get('nombre');
        $clave = $req->get('clave');
        if ($req->imagen) {
            $req->validate([
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }
        $imagen = $req->file('imagen');
        try {
            $usuario = Usuario::where('Id_usuario', $id)->first();
            $usuario->Nombre = $nombre;
            $usuario->Nick = $nick;

            if ($clave != null) {
                $clave = md5($req->get('clave'));
                $usuario->Clave = $clave;
            }
            if ($imagen != null) {
                $req->validate([
                    'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $nomimagen = time() . '.' . $req->imagen->extension();
                $usuario->Foto = 'images/users/' . $nomimagen;
                $req->imagen->move(public_path('images/users'), $nomimagen);
            }
            $mensaje = 'Perfil modificado con éxito';
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


        if (session()->has('idioma')) {
            return view('en/vistasadmin/perfiladmin', $datos);
        } else {
            return view('es/vistasadmin/perfiladmin', $datos);
        }
    }

    /**
     * Registra un usuario nuevo.
     * @param Request $req Recibe los datos del formulario de registro.
     * @return Lista de usuarios despues de haber realizado la insercion del usuario nuevo.
     * @author Victor
     */
    public function addUsuario(Request $req) {
        $miusuario = session()->get('usuario');

        $nick = $req->get('usuario');
        $clave = $req->get('clavenuevo');
        $claveCod = md5($clave);
        $nombre = $req->get('nombre');
        if ($req->file('imagen')) {
            $req->validate([
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $foto = $req->file('imagen');
            $nomImagen = time() . '.' . $foto->extension();
            $req->imagen->move(public_path('images/users/'), $nomImagen);
        } else {
            $nomImagen = 'general.jpg';
        }

        if ($req->has('rol')) {
            $rol = 1;
        } else {
            $rol = 0;
        }
        $usuario = new Usuario;
        $usuario->Nick = $nick;
        $usuario->Clave = $claveCod;
        $usuario->Nombre = $nombre;
        $usuario->Foto = 'images/users/' . $nomImagen;
        $usuario->save();

        $usuarioadd = Usuario::where('Nick', '=', $nick)->where('Clave', '=', $claveCod)->first();

        $usurol = new Usuario_Rol;
        $usurol->Id_rol = $rol;
        $usurol->Id_usuario = $usuarioadd->Id_usuario;
        $usurol->save();

        $datos = self::selectUsuarios();
        $datos2 = self::selectRoles();

        if (session()->has('idioma')) {
            return view('en/vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
        } else {
            return view('es/vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
        }
    }

    /**
     * Devuelve el listado de usuarios para mostrar en el crud, los resultados aparecen paginados
     * @return LengthAwarePaginator
     * @author Victor
     */
    private function selectUsuarios() {
        $miusuario = \Session::get('usuario');
        $datos = \DB::table('usuarios')
                ->join('usuario_rol', 'usuarios.Id_usuario', '=', 'usuario_rol.Id_usuario')
                ->select('usuarios.*', 'usuario_rol.Id_rol')
                ->where('usuarios.Id_usuario', '!=', $miusuario->Id_usuario)
                ->orderBy('Nombre', 'ASC')
                ->paginate(3);
        return $datos;
    }

    /**
     * Devuelve la lista de los roles en la base de datos.
     * @return type
     * @author Victor
     */
    private function selectRoles() {
        $datos2 = \DB::Select('Select * from rol');
        return $datos2;
    }

    /**
     * Carga el crud de usuarios con la lista de usuarios y roles.
     * @return type
     * @author Victor
     */
    public function crudUsuarios() {
        $datos = self::selectUsuarios();
        $datos2 = self::selectRoles();

        if (session()->has('idioma')) {
            return view('en/vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
        } else {
            return view('es/vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
        }
    }

    /**
     * Recibe la opcion seleccionada en el crud (Modificar/Eliminar) y llama a la funcion correspondiente.
     * @param Request $req Recibe los datos del usuario sobre el que se desee que se realicen los cambios.
     * @return type
     * @author Victor
     * En desuso tras cambiarlo a ajax.
     */
//    public function eleccionCrud(Request $req) {
//
//        if ($req->has('modUsuario')) {
//            $this->modificarUsuario($req);
//        }
//
//        if ($req->has('eliminarUsuario')) {
//            $this->eliminarUsuario($req);
//        }
//
//        $datos = self::selectUsuarios();
//        $datos2 = self::selectRoles();
//        return view('vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
//    }

    /**
     * Llena la base de datos de usuarios random para testeo.
     * @author Victor
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
     * @author Victor y Laura
     */
    public function updateUsuario(Request $req) {
//        $id = $_POST['id'];
//        $nick = $_POST['nick'];
//        $nombre = $_POST['nombre'];
//        $rol = $_POST['rol'];
//        $clave = $_POST['clave'];
        $id = $req->get('idusumod');
        $nick = $req->get('usuariomod');
        $nombre = $req->get('nombremod');
        $rol = $req->get('rolmod');
        $clave = $req->get('clavemod');

        //Nick de login y nombre
        $usuario = Usuario::where('Id_usuario', $id)->first();
        $usuario->Nick = $nick;
        $usuario->Nombre = $nombre;

        //Imagen de perfil
        if ($req->file('imagenmod')) {
            $req->validate([
                'imagenmod' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $foto = $req->file('imagenmod');
            $nomImagen = time() . '.' . $foto->extension();
            $req->imagenmod->move(public_path('images/users/'), $nomImagen);
            $usuario->Foto = 'images/users/' . $nomImagen;
        }

        //Clave
        if ($clave != null) {
            $claveCod = md5($clave);
            $usuario->clave = $claveCod;
        }

        $usuario->save();

        //Rol
        $usuRol = Usuario_Rol::where('Id_usuario', $id)->first();
        $usuRol->Id_rol = $rol;
        $usuRol->save();

        $datos = self::selectUsuarios();
        $datos2 = self::selectRoles();


        if (session()->has('idioma')) {
            return view('en/vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
        } else {
            return view('es/vistasadmin/crudusuario', ['datos' => $datos, 'datos2' => $datos2]);
        }
    }

    /**
     * Borra los datos de un usuario de la BBDD teniendo en cuenta su id único.
     * @param Request $request
     * @author Victor
     */
    public function deleteUsuario(Request $request) {
        $id = $request->input('id');
        $usuario = Usuario::where('Id_usuario', $id)->delete();
        exit;
    }

}
