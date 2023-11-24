<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\OblikradaRepositoryInterface;
use Illuminate\Http\Request;
class OblikradaController extends Controller
{

    public function __construct(readonly private OblikradaRepositoryInterface $oblikradaInterface)
    {
    }

    public function index(){

        $data = $this->oblikradaInterface->getAll();
        return view('obracunzarada::oblikrada.oblikrada_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->oblikradaInterface->getById($id);
        return view('obracunzarada::oblikrada.oblikrada_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->oblikradaInterface->update($request->id,$updateData);
        return redirect()->route('oblikrada.index');
    }
}
