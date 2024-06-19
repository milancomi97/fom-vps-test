<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ArhivaController extends Controller
{

    public function __construct(

     )
    {
    }



    public function index(Request $request)
    {

        return view('obracunzarada::arhiva.arhiva_index');
    }

    public function mesec(Request $request)
    {


        $arhiva_datum=$request->arhiva_datum;

        return view('obracunzarada::arhiva.arhiva_mesec',['arhiva_datum'=>$arhiva_datum]);
    }

    public function radnik(Request $request)
    {


        return view('obracunzarada::arhiva.arhiva_radnik');
    }

}
