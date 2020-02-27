<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Usuario_Rol;
use App\Models\Imagen;
use App\Models\Tablero_Dimension;
use App\Models\Tablero;
use App\Models\Accion;
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
        session()->forget('actual');
        $idUsuario = session()->get('usuario')->Id_usuario;

        $contextos = \DB::table('tableros')
                ->select('Id_tablero', 'Nombre', 'Imagen')
                ->where('Id_usuario', '=', $idUsuario)
                ->whereNull('Puntero')
                ->get();
        
        $dimensiones = \DB::table('dimensiones')
                ->select('dimensiones.Id_dimension', 'dimensiones.Nombre')
                ->get();

        if ($contextos->IsEmpty()) {
            $datos = [
                'contextos' => false,
                'dimensiones' => $dimensiones
            ];
        } else {
            $datos = [
                'contextos' => $contextos,
                'dimensiones' => $dimensiones
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
        if ($req->get('anterior')) {
            $puntero=$req->get('anterior');
        }else{
        $puntero = $req->get('actualtablero');
        }
        //dd($puntero);
        session()->put('actual', $puntero);
        $dimension = \DB::table('dimensiones')
                ->select('dimensiones.Filas', 'dimensiones.Dimension', 'dimensiones.Columnas')
                ->join('tablero_dimension', 'tablero_dimension.Id_dimension', 'dimensiones.Id_dimension')
                ->where('tablero_dimension.Id_tablero', $puntero)
                ->first();
        $dimensiones = \DB::table('dimensiones')
                ->select('dimensiones.Id_dimension', 'dimensiones.Nombre')
                ->get();
        
        $aux = \DB::table('tableros')
                ->select('tableros.Puntero', 'tableros.Id_tablero', 'Imagen', 'Nombre', 'Posicion', 'Accion')
                ->where('Puntero', '=', $puntero)
                ->get();

        $numPags = \DB::table('tableros')->select('Paginas')->where('Id_tablero', '=', $puntero)->first();

        //Se crea un objeto Tablero por defecto.
        $blanco = new Tablero;
        $blanco->Imagen = "images/tabs/blanco.jpg";
        $blanco->Puntero = $puntero;

        $casPorPag = $dimension->Filas * $dimension->Columnas;
        $casTotal = $numPags->Paginas * $casPorPag;

        $acciones = Accion::all();
        if (!$aux->IsEmpty()) {
            //Se obtiene el número de página más alto, las casillas por página, el número total de casillas y la dimensión del preset.
            //dd($numPags);
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
                'dimensiones' => $dimensiones,
                'paginas' => $numPags->Paginas,
                'acciones' => $acciones
            ];
        } else {
            for ($i = 1; $i <= $casTotal; $i++) {
                $subcontextos[$i] = $blanco;
            }
            $datos = [
                'subcontextos' => $subcontextos,
                'paginas' => $numPags->Paginas,
                'casTotal' => $casTotal,
                'casPorPag' => $casPorPag,
                'dimension' => $dimension,
                'dimensiones' => $dimensiones,
                'acciones' => $acciones
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
        $tablero->Accion = $req->accion;
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
        $req->image->move(public_path('images/tabs/'), $imageName);
        $tablero->Imagen = 'images/tabs/' . $imageName;
        $tablero->Paginas = 1;
        if (\Session::has('actual')) {
            $posicion = $req->posiadd;
            $tablero->Posicion=$posicion;
        } else {
            $tablero->Posicion = 0;
        }
        $tablero->save();
        //Cosas para mañana
        $idtablero = \DB::table('tableros')->where('Id_usuario', $idusuario)->max('Id_tablero');
        $tadi = new Tablero_Dimension;
        $tadi->Id_tablero = $idtablero;
        $tadi->Id_dimension = $req->dimension;
        $tadi->save();
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
        $tablero = Tablero::where('Id_tablero', '=', $req->actual)->first();
        $tablero->Nombre = $req->nombremod;
        $tablero->Accion = $req->accionlist;
        $tablero->Posicion = $req->posimo;
        $image_path = $tablero->Imagen; // the value is : localhost/project/image/filename.format
        if ($req->file('image')) {
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $req->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $req->image->extension();
            $req->image->move(public_path('images/tabs/'), $imageName);
            $tablero->Imagen = 'images/tabs/' . $imageName;
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
     * Elimina el tablero seleccionado.
     * @author Victor
     */
    public function eliminarTablero(Request $req) {
        try {
            \DB::table('tableros')->where('Id_tablero', '=', $req->idelim)->delete();
        } catch (Exception $ex) {
            echo 'Hostiazo que te crio';
        }
        if (\Session::has('actual')) {
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

    /**
     * Borrar pagina
     * @author Victor  Carlos 
     */
    public function eliminarPagina(Request $req) {
        $tablero = \DB::table('tableros')
                ->select('tableros.Puntero', 'tableros.Id_tablero', 'Imagen', 'tableros.Nombre', 'Posicion', 'dimensiones.Dimension', 'dimensiones.Filas', 'dimensiones.Columnas')
                ->join('tablero_dimension', 'tableros.Id_tablero', '=', 'tablero_dimension.Id_tablero')
                ->join('dimensiones', 'tablero_dimension.Id_dimension', '=', 'dimensiones.Id_dimension')
                ->where('tableros.Id_tablero', '=', $req->anterior)
                ->first();
        $pagina = $req->pagina; // pag atual
        $casPorPag = $tablero->Filas * $tablero->Columnas; // 3 6 12
        $maximoPaginaBorrar = $pagina * $casPorPag;
        $minimoPaginaBorrar = ($pagina - 1) * $casPorPag;
        \DB::table('tableros')
                ->where('Posicion', '<=', $maximoPaginaBorrar) //12
                ->where('Posicion', '>', $minimoPaginaBorrar)//7
                ->where('Puntero', $tablero->Id_tablero)
                ->delete();
        \DB::table('tableros')
                ->where('Posicion', '>', $maximoPaginaBorrar)
                ->where('Puntero', $tablero->Id_tablero)
                ->decrement('Posicion', $casPorPag);
        \DB::table('tableros')
                ->where('Id_tablero', \Session::get('actual'))
                ->decrement('Paginas', 1);
        
        $datos = self::cargarSubcontextos($req);
        return view('vistasusuario/subcontextosusuario', $datos);
    }

    /**
     * Añade una agina en blanco
     * @author Victor
     */
    public function addPagina(Request $req) {
        \DB::table('tableros')
                ->where('Id_tablero', \Session::get('actual'))
                ->increment('Paginas', 1);
        
        $datos = self::cargarSubcontextos($req);
        return view('vistasusuario/subcontextosusuario', $datos);
    }
    
    /**
     * Vacia un subcontextio
     * @author Carlos y Victor
     */
    public function DOOOOM(Request $req){
        \DB::table('tableros')
                ->where('Puntero', \Session::get('actual'))
                ->delete();
        
        $tablero = Tablero::where('Id_tablero', '=', \Session::get('actual'))->first();
        $tablero->Paginas = 1;
        $tablero->save();
        $datos = self::cargarSubcontextos($req);
        return view('vistasusuario/subcontextosusuario', $datos);
        }
}
