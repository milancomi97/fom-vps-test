<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\OblikradaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Illuminate\Http\Request;
class VrsteplacanjaController extends Controller
{

    public function __construct(readonly private VrsteplacanjaRepositoryInterface $vrsteplacanjaInterface)
    {
    }



    public function index(){

        $data = $this->vrsteplacanjaInterface->getAll();
        return view('obracunzarada::vrsteplacanja.vrsteplacanja_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->vrsteplacanjaInterface->getById($id);
        return view('obracunzarada::vrsteplacanja.vrsteplacanja_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->vrsteplacanjaInterface->update($request->id,$updateData);
        return redirect()->route('vrsteplacanja.index');
    }
}
