<?php

namespace App\Modules\Osnovnipodaci\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use Illuminate\Http\Request;

class OrganizacionecelineController  extends Controller
{


    public function __construct(readonly private OrganizacionecelineRepositoryInterface $organizacionecelineInterface)
    {
    }

    public function index(){

        $data = $this->organizacionecelineInterface->getAll();
        return view('osnovnipodaci::organizacioneceline.organizacioneceline_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->organizacionecelineInterface->getById($id);
        return view('osnovnipodaci::organizacioneceline.organizacioneceline_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->organizacionecelineInterface->update($request->id,$updateData);
        return redirect()->route('organizacioneceline.index');
    }
}
