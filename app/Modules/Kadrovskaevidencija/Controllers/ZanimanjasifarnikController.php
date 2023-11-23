<?php

namespace App\Modules\Kadrovskaevidencija\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Kadrovskaevidencija\Repository\ZanimanjasifarnikRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OpstineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class ZanimanjasifarnikController extends Controller
{

    public function __construct(protected readonly ZanimanjasifarnikRepositoryInterface $zanimanjaInterface)
    {
    }

    public function index(){

        $data = $this->zanimanjaInterface->getAll();
        return view('kadrovskaevidencija::zanimanjasifarnik.zanimanjasifarnik_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->zanimanjaInterface->getById($id);
        return view('kadrovskaevidencija::zanimanjasifarnik.zanimanjasifarnik_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->zanimanjaInterface->update($request->id,$updateData);
        return redirect()->route('zanimanjasifarnik.index');
    }
}
