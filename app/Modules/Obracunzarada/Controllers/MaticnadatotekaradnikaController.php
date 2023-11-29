<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

class MaticnadatotekaradnikaController extends Controller
{

    public function __construct(private readonly \App\Modules\Osnovnipodaci\Repository\OpstineRepositoryInterface $opstineInterface)
    {
    }

    public function index(){

        $opstine = $this->opstineInterface->getSelectOptionData();
        return view('obracunzarada::maticnadatotekaradnika.maticnadatotekaradnika_index',['opstine'=>$opstine]);

    }

}
