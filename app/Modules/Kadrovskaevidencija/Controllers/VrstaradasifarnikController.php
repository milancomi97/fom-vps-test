<?php

namespace App\Modules\Kadrovskaevidencija\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Kadrovskaevidencija\Repository\VrstaradasifarnikRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\ZanimanjasifarnikRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OpstineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class VrstaradasifarnikController extends Controller
{

    public function __construct(protected readonly VrstaradasifarnikRepositoryInterface $vrstaradasifarnikIterface)
    {
    }

    public function index(){

        $data = $this->vrstaradasifarnikIterface->getAll();
        return view('kadrovskaevidencija::vrstaradasifarnik.vrstaradasifarnik_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->vrstaradasifarnikIterface->getById($id);
        return view('kadrovskaevidencija::vrstaradasifarnik.vrstaradasifarnik_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->vrstaradasifarnikIterface->update($request->id,$updateData);
        return redirect()->route('vrstaradasifarnik.index');
    }
}
