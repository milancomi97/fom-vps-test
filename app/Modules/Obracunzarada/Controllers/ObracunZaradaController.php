<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

class ObracunZaradaController extends Controller
{

    public function index(){
        return view('obracunzarada::obracunzarada.obracunzarada_index');
    }

}
