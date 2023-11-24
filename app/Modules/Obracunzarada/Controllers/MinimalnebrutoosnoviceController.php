<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\KreditoriRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\OblikradaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Illuminate\Http\Request;

class MinimalnebrutoosnoviceController extends Controller
{

    public function __construct(readonly private MinimalnebrutoosnoviceRepositoryInterface $minimalnebrutoosnoviceInterface)
    {
    }



    public function index(){

        $data = $this->minimalnebrutoosnoviceInterface->getAll();
        return view('obracunzarada::minimalnebrutoosnovice.minimalnebrutoosnovice_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->minimalnebrutoosnoviceInterface->getById($id);
        return view('obracunzarada::minimalnebrutoosnovice.minimalnebrutoosnovice_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->minimalnebrutoosnoviceInterface->update($request->id,$updateData);
        return redirect()->route('minimalnebrutoosnovice.index');
    }
}
