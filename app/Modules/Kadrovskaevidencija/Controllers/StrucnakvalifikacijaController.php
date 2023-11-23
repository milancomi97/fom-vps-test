<?php

namespace App\Modules\Kadrovskaevidencija\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use Illuminate\Http\Request;

class StrucnakvalifikacijaController extends Controller
{

    public function __construct(protected readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface)
    {
    }

    public function index(){

        $data = $this->strucnakvalifikacijaInterface->getAll();
        return view('kadrovskaevidencija::strucnakvalifikacija.strucnakvalifikacija_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->strucnakvalifikacijaInterface->getById($id);
        return view('kadrovskaevidencija::strucnakvalifikacija.strucnakvalifikacija_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->strucnakvalifikacijaInterface->update($request->id,$updateData);
        return redirect()->route('strucnakvalifikacija.index');
    }
}
