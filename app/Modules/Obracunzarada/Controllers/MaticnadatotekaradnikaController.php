<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

class MaticnadatotekaradnikaController extends Controller
{

    public function index(){

        return view('obracunzarada::maticnadatotekaradnika.maticnadatotekaradnika_index');

    }

}
