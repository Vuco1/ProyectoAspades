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
     * @version 2.1
     */
    public function cargarContextos() {
        session()->forget('puntero');
        $idUsuario = session()->get('usuario')->Id_usuario;

        $contextos = \DB::table('tableros')
                ->select('Id_tablero', 'Nombre', 'Imagen')
                ->where('Id_usuario', '=', $idUsuario)
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
     * @version 2.2
     */
    public function cargarSubcontextos($req) {
        $puntero = $req->get('actual');
        session()->put('actual', $puntero);

        //Se obtienen todos los subcontextos que apuntan al contexto padre.
        $aux = \DB::table('tableros')
                ->select('tableros.Puntero', 'tableros.Id_tablero', 'Imagen', 'Nombre', 'Posicion', 'dimensiones.Dimension', 'dimensiones.Filas', 'dimensiones.Columnas')
                ->join('tablero_dimension', 'tableros.Id_tablero', '=', 'tablero_dimension.Id_tablero')
                ->join('dimensiones', 'tablero_dimension.Id_dimension', '=', 'dimensiones.Id_dimension')
                ->where('Puntero', '=', $puntero)
                ->get();
        if (!$aux->IsEmpty()) {
            //Se obtiene el número de página más alto, las casillas por página, el número total de casillas y la dimensión del preset.
            $numPags = \DB::table('tableros')->select('Paginas')->where('Id_tablero', '=', $puntero)->first();
            //dd($numPags);
            $casPorPag = $aux[1]->Filas * $aux[1]->Columnas;
            $casTotal = $numPags->Paginas * $casPorPag;
            $dimension = $aux[1]->Dimension;

            //Se crea un objeto Tablero por defecto.
            $blanco = new Tablero;
            $blanco->Imagen = "images/tabs/blanco.jpg";
            $blanco->Puntero = $puntero;
            $blanco->Filas = $aux[1]->Filas;

            //Se crea un segundo array con tantas posiciones como número total de casillas habrá y se rellenan con el Tablero por defecto.
            $subcontextos = array();
            for ($i = 1; $i <= $casTotal; $i++) {
                $subcontextos[$i] = $blanco;
            }
            //Se asigna cada Tablero del array aux a la posición que le corresponde en el array subcontextos.
            foreach ($aux as $s) {
                $subcontextos[$s->Posicion] = $s;
            }
            $datos = [
                'subcontextos' => $subcontextos,
                'casTotal' => $casTotal,
                'casPorPag' => $casPorPag,
                'dimension' => $dimension,
                'paginas' => $numPags->Paginas
            ];
        } else {
            $datos = [
                'subcontextos' => false
            ];
        }

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
        if (\Session::has('actual')) {
            $idcontexto = \Session::get('actual');
        } else {
            $idcontexto = null;
        }
        $tablero->Puntero = $idcontexto;
        //Subida de la imagen.
        $req->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $req->image->extension();
        $req->image->move(public_path('images'), $imageName);
        $tablero->Imagen = 'images/tabs' . $imageName;
        $tablero->Pagina = 0;
        if (\Session::has('actual')) {
            $posicion = $req->posicion;
        } else {
            $tablero->Pagina = 1;
            $tablero->Posicion = 0;
        }
        $tablero->save();

        if (\Session::has('actual')) {
            $datos = self::cargarSubcontextos($req);
            return view('vistasusuario/subcontextosusuario', $datos);
        } else {
            $datos = self::cargarContextos();
            return view('vistasusuario/contextosusuario', $datos);
        }
    }

    /**
     * Obtiene la fila y la columna del string de posicion que se le pase a la funcion
     * @param type $posicion
     * @return type
     * @author Victor
     */
    public function sacarPosicion($posicion) {
        $columna = substr($posicion, 1, 1);
        $fila = substr($posicion, 3);
        $posiciones = ['fila' => $fila, 'columna' => $columna];
        return $posiciones;
    }

    /**
     * Modifica el tablero seleccionado.
     * @author Victor
     */
    public function modificarTablero(Request $req) {
        $tablero = Tablero::where('Id_tablero', '=', $req->id_tablero)->first();
        $imagen = Imagen::where('Id_imagen', $req->id_imagen)->first();
        $tablero->Nombre = $req->nombre;
        $image_path = $tablero->Ruta;  // the value is : localhost/project/image/filename.format
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $req->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $req->image->extension();
        $req->image->move(public_path('images'), $imageName);
        $tablero->Imagen = 'images/' . $imageName;
        $tablero->save();
        if (\Session::has('id')) {
            $datos = self::cargarSubcontextos($req);
            return view('vistasusuario/subcontextosusuario', $datos);
        } else {
            $datos = self::cargarContextos();
            return view('vistasusuario/contextosusuario', $datos);
        }
    }

    /**
     * Elimina el tablero seleccionado.
     * @author Victor
     */
    public function eliminarTablero(Request $req) {
        try {
            \DB::table('tableros')->where('Id_tablero', '=', $req->idelim)->delete();
        } catch (Exception $ex) {
            echo 'Hostiazo que te crio';
        }
        if (\Session::has('id')) {
            $datos = self::cargarSubcontextos($req);
            return view('vistasusuario/subcontextosusuario', $datos);
        } else {
            $datos = self::cargarContextos();
            return view('vistasusuario/contextosusuario', $datos);
        }
    }

    /**
     * Comprueba que es el tablero anterior y carga ese tablero
     * @param Request $req
     * @return type
     * @author Victor
     */
    public function tableroAnterior(Request $req) {
        $tablero = Tablero::where('Id_tablero', $req->puntero);

        if ($tablero->Puntero == null) {
            $datos = self::cargarContextos();
            return view('vistasusuario/contextosusuario', $datos);
        } else {
            $datos = self::cargarSubcontextos($req);
            return view('vistasusuario/subcontextosusuario', $datos);
        }
    }

}
