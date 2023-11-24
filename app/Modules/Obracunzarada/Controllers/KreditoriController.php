<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\KreditoriRepositoryInterface;
use App\Modules\Obracunzarada\Repository\OblikradaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Illuminate\Http\Request;
class KreditoriController extends Controller
{

    public function __construct(readonly private KreditoriRepositoryInterface $kreditoriInterface)
    {
    }



    public function index(){

        $data = $this->kreditoriInterface->getAll();
        return view('obracunzarada::kreditori.kreditori_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->kreditoriInterface->getById($id);
        return view('obracunzarada::kreditori.kreditori_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->kreditoriInterface->update($request->id,$updateData);
        return redirect()->route('kreditori.index');
    }
}
