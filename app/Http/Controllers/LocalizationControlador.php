<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LocalizationControlador extends Controller {

    public function index(Request $request) {
        $locale = \App::getLocale();
        
        //set’s application’s locale
        app()->setLocale($locale);

        
        return view('index');
    }

}
