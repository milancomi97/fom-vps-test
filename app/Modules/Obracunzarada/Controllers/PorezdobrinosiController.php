<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\OblikradaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PorezdoprinosiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Illuminate\Http\Request;
class PorezdobrinosiController extends Controller
{

    public function __construct(readonly private PorezdoprinosiRepositoryInterface $porezdoprinosiInterface)
    {
    }



    public function index(){

        $data = $this->porezdoprinosiInterface->getAll();
        return view('obracunzarada::porezdoprinosi.porezdoprinosi_index', ['data' => $data]);

    }
    public function edit($id){
        $data = $this->porezdoprinosiInterface->getById($id);
        return view('obracunzarada::porezdoprinosi.porezdoprinosi_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->porezdoprinosiInterface->update($request->id,$updateData);
        return redirect()->route('porezdoprinosi.index');
    }
}
