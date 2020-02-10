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
     */
    public function obtenerContextos(Request $req) {
        $idUsuario = session()->get('usuario')->Id_usuario;
        $contextos = Tablero::where('Id_usuario', $idUsuario)->get();
        
        $datos = [
            'contextos' => $contextos
        ];

        return view('vistasusuario/contextosusuario', $datos);
    }

    /**
     * Obtiene el id de la imagen elegida y nos devuelve los tableros o galería de imágenes asignados
     * a la misma.
     * @param Request $req
     * @return type
     */
    public function contextosUsuario(Request $req) {
        $id = $req->get('id');
        $idtablero = Tablero_Imagen::where('Id_tablero', $id)->first();
       
        $contextos = Tablero::where('Puntero',$idtablero->Id_tablero)->get();
        foreach ($contextos as $contexto) {
            $idtablero2 = Tablero_Imagen::where('Id_tablero', $contexto->Id_tablero)->first();
            $imgtablero[] = Imagen::where('Id_imagen', $idtablero2->Id_imagen)->first();
        
        $datos = [
            'imgtab' => $imgtablero
        ];
        }

        return view('vistasusuario/subcontextosusuario', $datos);
    }

}
