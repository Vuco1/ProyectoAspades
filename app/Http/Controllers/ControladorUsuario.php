<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Usuario_Rol;
use App\Models\Imagen;
use App\Models\Tablero_Imagen;
use App\Models\Tablero;

class ControladorUsuario extends Controller {

    /**
     * Coge los datos del tablero de la sesión y con la id del mismo, obtiene los subtableros 
     * del usuario.
     * @param Request $req
     * @return type
     */
    public function iniciarContextos(Request $req) {
        $tablero = session()->get('tablero');
        $contextos = Tablero::where('Puntero', $tablero->Id_tablero)->get();
        foreach ($contextos as $contexto) {
            $idtablero = Tablero_Imagen::where('Id_tablero', $contexto->Id_tablero)->first();
            $imgtablero[] = Imagen::where('Id_imagen', $idtablero->Id_imagen)->first();

            $datos = [
                'imgtab' => $imgtablero
            ];
        }

        $datos = self::cargarContextos();
        return view('vistasusuario/contextosusuario', $datos);
    }

    public function cargarContextos() {
        $contextos = Tablero::whereNull('Puntero')->get();
        foreach ($contextos as $contexto) {
            $idtablero = Tablero_Imagen::where('Id_tablero', $contexto->Id_tablero)->first();
            $imgtablero[] = Imagen::where('Id_imagen', $idtablero->Id_imagen)->first();

            $datos = [
                'imgtab' => $imgtablero
            ];
        }
        return $datos;
    }
    
 
    /**
     * Obtiene el id de la imagen elegida y nos devuelve los tableros o galería de imágenes asignados
     * a la misma.
     * @param Request $req
     * @return type
     */
    public function contextosUsuario(Request $req) {
        $id = $req->get('id');
        \Session::put('id',$id);
        $idtablero = Tablero_Imagen::where('Id_tablero', $id)->first();

        $contextos = Tablero::where('Puntero', $idtablero->Id_tablero)->get();
        foreach ($contextos as $contexto) {
            $idtablero2 = Tablero_Imagen::where('Id_tablero', $contexto->Id_tablero)->first();
            $imgtablero[] = Imagen::where('Id_imagen', $idtablero2->Id_imagen)->first();

            $datos = [
                'imgtab' => $imgtablero
            ];
        } 
        return view('vistasusuario/subcontextosusuario', $datos);
    }

    /**
     * Sube una imagen a nuestra carpeta de images 
     */
    public function subirTablero(Request $req) {
        $req->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $req->image->extension();
        $req->image->move(public_path('images'), $imageName);
        $imagen = new Imagen;
        $imagen->Nombre = $req->nombre;
        $imagen->Ruta = 'images/' . $imageName;
        $imagen->save();

        $tablero = new Tablero;
        $usuario = session()->get('usuario');
        $id = $usuario->Id_usuario;
        $tablero->Id_usuario = $id;
        $tablero->Nombre = $req->nombre;
        if (\Session::has('id')) {
            $id=\Session::get('id');
        } else {
           $id=0;
        }
        $tablero->Puntero = 0;
        $tablero->save();
        
        //Es un poco crispy, si meten dos a la vez a saber que pasa
        $auxtablero = Tablero::max('Id_tablero');
        $auximagen = Imagen::max('Id_imagen');
        $union = new Tablero_Imagen;
        $union->Id_tablero = $auxtablero;
        $union->Id_imagen = $auximagen;
        $union->save();
        $datos = self::cargarContextos();
        return view('vistasusuario/contextosusuario', $datos);
    }
    
    public function modificarFoto(Request $req) {
        $req->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $imagen = $req->file('imagen');
            $user = session()->get('usuario');

            $usuario = Usuario::where('Id_usuario', $user->Id_usuario)->first();
            $nomimagen = $imagen->getClientOriginalName();
            $usuario->Foto = 'images/' . $nomimagen;
            $usuario->save();

            $req->imagen->move(public_path('images'), $nomimagen);

            $men = 'Foto de perfil modificada.';
        } catch (Exception $ex) {
            $men = 'No se ha podido modificar la foto de perfil.';
        }

        $usuario = Usuario::where('Id_usuario', $user->Id_usuario)->first();
        session()->put('usuario', $usuario);
        session()->put('imgperfil', $nomimagen);

        $datos = [
            'mensaje' => $men
        ];
        return view('vistasusuario/iniciousuario');
    }

}
