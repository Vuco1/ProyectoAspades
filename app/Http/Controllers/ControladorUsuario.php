<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_Rol;
use App\Tablero;
use App\Tablero_Imagen;
use App\Imagen;

class ControladorUsuario extends Controller {

    public function iniciarContextos(Request $req) {
        $tablero = session()->get('tablero');
        $contextos = Tablero::where('Puntero', $tablero->Id_tablero)->get();
        foreach ($contextos as $contexto) {
            $idtablero = Tablero_Imagen::where('Id_tablero', $contexto->Id_tablero)->first();
            $imgtablero = Imagen::where('Id_imagen', $idtablero->Id_imagen)->first();
            
            $datos = [
            'imgtab' => $imgtablero
            ];
        }

        return view('vistausuario/contextosusuario', $datos);
    }

}
