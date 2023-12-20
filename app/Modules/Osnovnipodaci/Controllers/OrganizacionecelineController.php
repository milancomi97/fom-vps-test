<?php

namespace App\Modules\Osnovnipodaci\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;
use Illuminate\Http\Request;

class OrganizacionecelineController  extends Controller
{


    public function __construct(
        readonly private OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly RadniciRepository $radniciInterface,

    )
    {
    }

    public function index(){

        $data = $this->organizacionecelineInterface->getAll();
        return view('osnovnipodaci::organizacioneceline.organizacioneceline_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->organizacionecelineInterface->getById($id);
        $radnici = $this->radniciInterface->getAllActive();

        return view('osnovnipodaci::organizacioneceline.organizacioneceline_edit', ['radnici'=>$radnici,'data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);

        $updateData['poenteri_ids'] = json_encode($updateData['poenteri_ids'] );
        $updateData['odgovorna_lica_ids'] = json_encode($updateData['odgovorna_lica_ids'] );
        $data = $this->organizacionecelineInterface->update($request->id,$updateData);
        return redirect()->route('organizacioneceline.index');
    }
}
