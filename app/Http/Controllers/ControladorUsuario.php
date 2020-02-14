<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Usuario_Rol;
use App\Models\Imagen;
use App\Models\Tablero_Imagen;
use App\Models\Tablero;
use Illuminate\Support\Facades\File;

class ControladorUsuario extends Controller {

    /**
     * Obtiene los contextos del usuario guardado en la sesión a partir de su Id.
     * @param Request $req
     * @return type
     * @author Laura
     * @version 2.0
     */
    public function obtenerContextos(Request $req) {
        session()->forget('puntero');
        $idUsuario = session()->get('usuario')->Id_usuario;

        $contextos = \DB::table('imagenes')
                ->select('imagenes.Id_imagen', 'imagenes.Nombre', 'imagenes.Ruta')
                ->join('tableros', 'tableros.Id_tablero', '=', 'imagenes.Id_tablero')
                ->where('tableros.Id_usuario', '=', $idUsuario)
                ->whereNull('Puntero')
                ->get();

        if ($contextos->IsEmpty()) {
            $datos = [
                'contextos' => false
            ];
        } else {
            $datos = [
                'contextos' => $contextos
            ];
        }

        return view('vistasusuario/contextosusuario', $datos);
    }

    /**
     * 
     * @param Request $req
     * @return type
     * @author Laura
     * @version 2.0
     */
    public function obtenerSubcontextos(Request $req) {
        $puntero = $req->get('puntero');
        session()->put('puntero', $puntero);

        $subcontextos = \DB::table('imagenes')
                ->select('imagenes.Id_imagen', 'imagenes.Nombre', 'imagenes.Ruta')
                ->join('tableros', 'tableros.Id_tablero', '=', 'imagenes.Id_tablero')
                ->where('Puntero', '=', $puntero)
                ->get();

        if ($subcontextos->IsEmpty()) {
            $datos = [
                'subcontextos' => false
            ];
        } else {
            $datos = [
                'subcontextos' => $subcontextos
            ];
        }

        return view('vistasusuario/subcontextosusuario', $datos);
    }

    /**
     * Sube una imagen a nuestra carpeta de images
     * @author Víctor
     * @version 1.0
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
            $id = \Session::get('id');
            $contextos = Tablero_Imagen::where('Id_imagen', $id)->first();
            $idcontexto = $contextos->Id_tablero;
        } else {
            $id = null;
        }
        $tablero->Puntero = $idcontexto;
        $tablero->save();

        //Es un poco crispy, si meten dos a la vez a saber que pasa
        $auxtablero = Tablero::max('Id_tablero'); //falta poner que sea del usuario
        $auximagen = Imagen::max('Id_imagen');
        $union = new Tablero_Imagen;
        $union->Id_tablero = $auxtablero;
        $union->Id_imagen = $auximagen;
        $union->save();
        if (\Session::has('id')) {
            $datos = self::cargarSubcontextos($id);
            return view('vistasusuario/subcontextosusuario', $datos);
        } else {
            $datos = self::cargarContextos();
            return view('vistasusuario/contextosusuario', $datos);
        }
    }

}
