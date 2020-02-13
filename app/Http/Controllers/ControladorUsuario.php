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
     * Obtiene los contextos del usuario guardado en la sesión a partir de su Id.
     * @param Request $req
     * @return type
     * @author Laura
     * @version 2.0
     */
    public function obtenerContextos(Request $req) {
        //dd(session()->get('usuario'));
        $idUsuario = session()->get('usuario')->Id_usuario;
        $contextos = \DB::table('imagenes')
                ->join('imagenes.Id_imagen', '=', 'pagina_imagen.Id_imagen')
                ->join('tablero_pagina.Id_pagina', '=', 'pagina_imgagen.Id_pagina')
                ->join('Tablero.Id_tablero', '=', 'tablero_pagina.Id_tablero')
                ->select('Imagenes.Id_imagen', 'Imagenes.Nombre', 'Imagenes.ruta')
                ->where('Id_usuario', '=', $idUsuario)
                ->whereNull('Puntero');

        foreach ($contextos as $contexto) {
            $idTablero = Tablero_Pagina::where('Id_tablero', $contexto->Id_tablero)->first();
            $imgTablero[] = Imagen::where('Id_imagen', $idTablero->Id_imagen)->first(); 
        }
        $datos = [
                'imgTablero' => $imgTablero
        ];

        return view('vistasusuario/contextosusuario', $datos);
    }

    /**
     * Obtiene los contextos que no apuntan a ningún otro (Contextos generales).
     * @return type
     */
    public function cargarContextos() {
        \Session::forget('id');
        $contextos = Tablero::whereNull('Puntero')->get();
        if (!$contextos) {
            $datos = [
                    'imgTablero' => false
                ];
        } else {
            foreach ($contextos as $contexto) {
                $idtablero = Tablero_Imagen::where('Id_tablero', $contexto->Id_tablero)->first();
                $imgtablero[] = Imagen::where('Id_imagen', $idtablero->Id_imagen)->first();

                $datos = [
                    'imgTablero' => $imgtablero
                ];
            }
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
        \Session::put('id', $id);
        $datos = self::cargarSubcontextos($id);
        return view('vistasusuario/subcontextosusuario', $datos);
    }

    public function cargarSubcontextos($id) {
        $idtablero = Tablero_Imagen::where('Id_imagen', $id)->first();
        $contextos = Tablero::where('Puntero', $idtablero->Id_tablero)->get();
        if ($contextos->IsEmpty()) {
            $datos = [
                'imgTablero' => false
            ];
        } else {
            
            foreach ($contextos as $contexto) {
                $idtablero2 = Tablero_Imagen::where('Id_tablero', $contexto->Id_tablero)->first();
                $imgtablero[] = Imagen::where('Id_imagen', $idtablero2->Id_imagen)->first();

                $datos = [
                    'imgTablero' => $imgtablero
                ];
            }
        }
        return $datos;
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
            $id = \Session::get('id');
            $contextos = Tablero_Imagen::where('Id_imagen', $id)->first();
            $idcontexto = $contextos->Id_tablero;
        } else {
            $id = null;
        }
        $tablero->Puntero = $idcontexto;
        $tablero->save();

        //Es un poco crispy, si meten dos a la vez a saber que pasa
        $auxtablero = Tablero::max('Id_tablero');
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
