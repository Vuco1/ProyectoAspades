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
    public function cargarContextos() {
        session()->forget('puntero');
        $idUsuario = session()->get('usuario')->Id_usuario;

        $contextos = \DB::table('imagenes')
                ->select('imagenes.Id_imagen', 'tableros.Nombre', 'imagenes.Ruta')
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
        return $datos;
    }

    public function obtenerContextos() {
        $datos = self::cargarContextos();
        return view('vistasusuario/contextosusuario', $datos);
    }

    /**
     * Obtiene los Subcontextos que contiene un Contexto.
     * @param Request $req
     * @return type
     * @author Laura
     * @version 2.0
     */
    public function cargarSubcontextos($req) {
        $puntero = $req->get('puntero');
        session()->put('puntero', $puntero);

        $subcontextos = \DB::table('imagenes')
                ->select('imagenes.Id_imagen', 'imagenes.Ruta', 'imagenes.Pagina', 'imagenes.Columna', 'imagenes.Fila', 'tableros.Nombre', 'dimensiones.Dimension', 'dimensiones.Total_filas', 'dimensiones.Total_columnas')
                ->join('tableros', 'tableros.Id_tablero', '=', 'imagenes.Id_tablero')
                ->join('tablero_dimension', 'tableros.Id_tablero', '=', 'tablero_dimension.Id_tablero')
                ->join('dimensiones', 'tablero_dimension.Id_dimension', '=','dimensiones.Id_dimension')
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
        //dd($subcontextos);
        return $datos;
    }

    public function obtenerSubcontextos(Request $req) {
        $datos = self::cargarSubcontextos($req);
        return view('vistasusuario/subcontextosusuario', $datos);
    }

    /**
     * Sube una imagen a nuestra carpeta de images
     * @author Víctor
     * @version 1.0
     */
    public function subirTablero(Request $req) {
        //Creacion de tablero
        $tablero = new Tablero;
        $usuario = session()->get('usuario');
        $idusuario = $usuario->Id_usuario;
        $tablero->Id_usuario = $idusuario;
        $tablero->Nombre = $req->nombre;
        if (\Session::has('idcontexto')) {
            $idcontexto = \Session::get('idcontexto');
        } else {
            $idcontexto = null;
        }
        $tablero->Puntero = $idcontexto;
        $tablero->save();

        //Obtencion de la id del tablero recien creado.
        $auxtablero = Tablero::where('Id_usuario', $idusuario)->max('Id_tablero');

        //Subida de la imagen.
        $req->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $req->image->extension();
        $req->image->move(public_path('images'), $imageName);
        $imagen = new Imagen;
        $imagen->Ruta = 'images/' . $imageName;
        $imagen->Id_tablero = $auxtablero;
        if (\Session::has('idcontexto')) {
            $pagina = $req->pagina; //Decidir como vamos a hacerlo ;
            $imagen->Pagina = $pagina;
            $posicion = self::sacarPosicion($req->posicion);
            $imagen->Columna = $posicion->columna;
            $imagen->Fila = $posicion->fila;
        } else {
            $imagen->Pagina = 0;
            $imagen->Columna = 0;
            $imagen->Fila = 0;
        }
        $imagen->save();

        if (\Session::has('id')) {
            $datos = self::cargarSubcontextos($req);
            return view('vistasusuario/subcontextosusuario', $datos);
        } else {
            $datos = self::cargarContextos();
            return view('vistasusuario/contextosusuario', $datos);
        }
    }

    public function sacarPosicion($posicion) {
        $columna = substr($posicion, 1, 1);
        $fila = substr($posicion, 3);
        $posiciones = ['fila' => $fila, 'columna' => $columna];
        return $posiciones;
    }
    
    public function modidificarTablero(Request $req){
        $tablero=Tablero::where('Id_tablero', '=', $req->id_tablero);
        $imagen=Imagen::where('Id_tablero', $req->id_tablero);
        $tablero->Nombre=$req->nombre;
        $imagen->Ruta=$req->ruta;
        $tablero->save();
        $imagen->save();
    }
    
    
   public function eliminarTablero(Request $req){
       try{
            DB::table('tableros')->where('Id_tablero', '=', $req->id_tablero)->delete();
       } catch (Exception $ex) {
          echo 'Hostiazo que te crio' ;
       }
   }
}
