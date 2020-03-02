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
     * @return array $datos Contextos del usuario e ids y nombres de todas las dimensiones
     * @author Laura
     * @version 3.0
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
     * Obtiene los Subcontextos que contiene un Tablero padre.
     * @param Request $req
     * @return array $datos Datos de los tableros para cargar la vista de subcontextos
     * @author Laura y Víctor
     * @version 3.0
     */
    public function cargarSubcontextos($req) {
        //Se mete en la sesión el id del tablero padre
        if ($req->get('anterior')) {
            $puntero = $req->get('anterior');
        } else {
            $puntero = $req->get('actualtablero');
        }
        session()->put('actual', $puntero);

        //Se obtiene una lista de todas las dimensiones de la tabla para los selects de las ventanas modales
        $dimensiones = \DB::table('dimensiones')
                ->select('dimensiones.Id_dimension', 'dimensiones.Nombre')
                ->get();

        //Se obtienen todos los tableros que contiene el tablero padre
        $aux = \DB::table('tableros')
                ->select('tableros.Puntero', 'tableros.Id_tablero', 'Imagen', 'Nombre', 'Posicion', 'Accion')
                ->where('Puntero', '=', $puntero)
                ->get();

        //Se obtiene el número de filas y columnas y la clase de la dimensión del tablero padre
        $dimension = \DB::table('dimensiones')
                ->select('dimensiones.Filas', 'dimensiones.Dimension', 'dimensiones.Columnas')
                ->join('tablero_dimension', 'tablero_dimension.Id_dimension', 'dimensiones.Id_dimension')
                ->where('tablero_dimension.Id_tablero', $puntero)
                ->first();

        //Se obtiene el número de páginas del tablero padre y se calculan las casillas que tendrá cada página y las casillas en total
        $numPags = \DB::table('tableros')->select('Paginas')->where('Id_tablero', '=', $puntero)->first();
        $casPorPag = $dimension->Filas * $dimension->Columnas;
        $casTotal = $numPags->Paginas * $casPorPag;

        //Se crea un objeto Tablero auxiliar con datos por defecto
        $blanco = new Tablero;
        $blanco->Imagen = "images/tabs/blanco.jpg";
        $blanco->Puntero = $puntero;

        //Se crea un segundo array con tantas posiciones como número total de casillas habrá y se rellenan con el Tablero por defecto.
        $subcontextos = array();
        for ($i = 1; $i <= $casTotal; $i++) {
            $subcontextos[$i] = $blanco;
        }

        $acciones = Accion::all();

        if (!$aux->IsEmpty()) {
            //Se asigna cada Tablero del array aux a la posición que le corresponde.
            foreach ($aux as $s) {
                $subcontextos[$s->Posicion] = $s;
            }
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

        return $datos;
    }

    public function obtenerSubcontextos(Request $req) {
        $datos = self::cargarSubcontextos($req);
        return view('vistasusuario/subcontextosusuario', $datos);
    }

    /**
     * Sube un tablero a la BDD y la imagen que le corresponde a la carpeta images.
     * @author Víctor
     * @version 70.0
     */
    public function subirTablero(Request $req) {
        //Creación del tablero
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
            $tablero->Posicion = $posicion;
        } else {
            $tablero->Posicion = 0;
        }
        $tablero->save();

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
     * Obtiene la fila y la columna del string de posicion que se le pase a la funcion.
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
        $nombre = $req->nombremod;
        if ($nombre != null) {
            $tablero->Nombre = $nombre;
        }
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
     * @author Victor,Carlos y Laura
     */
    public function eliminarPagina(Request $req) {
        $tablero = \DB::table('tableros')
                ->select('tableros.Puntero', 'tableros.Paginas', 'tableros.Id_tablero', 'Imagen', 'tableros.Nombre', 'Posicion', 'dimensiones.Dimension', 'dimensiones.Filas', 'dimensiones.Columnas')
                ->join('tablero_dimension', 'tableros.Id_tablero', '=', 'tablero_dimension.Id_tablero')
                ->join('dimensiones', 'tablero_dimension.Id_dimension', '=', 'dimensiones.Id_dimension')
                ->where('tableros.Id_tablero', '=', $req->anterior)
                ->first();
        if ($tablero->Paginas > 1) {
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
        } else {
            \DB::table('tableros')
                    ->where('Puntero', \Session::get('actual'))
                    ->delete();
        }
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
    public function DOOOOM(Request $req) {
        \DB::table('tableros')
                ->where('Puntero', \Session::get('actual'))
                ->delete();

        $tablero = Tablero::where('Id_tablero', '=', \Session::get('actual'))->first();
        $tablero->Paginas = 1;
        $tablero->save();
        $datos = self::cargarSubcontextos($req);
        return view('vistasusuario/subcontextosusuario', $datos);
    }

    public function editarPerfilUsuario(Request $req) {
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
        $color = 'text-success';
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
            $color = 'text-danger';
        }

        $usuario = Usuario::where('Id_usuario', $id)->first();
        session()->put('usuario', $usuario);

        $datos = [
            'usuario' => $usuario,
            'mensaje' => $mensaje,
            'color' => $color
        ];

        return view('vistasusuario/perfilusuario', $datos);
    }

}
