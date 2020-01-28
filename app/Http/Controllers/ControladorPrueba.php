<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class ControladorPrueba extends Controller {

    function paginacion() {
        $users = Usuario::paginate(2);
        echo 'Hola';
        return view('pruebaPagination', ['usuarios' => $users]);
    }

}
