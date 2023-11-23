<?php

namespace App\Modules\Kadrovskaevidencija\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use Illuminate\Http\Request;

class RadnamestaController extends Controller
{

    public function __construct(protected readonly RadnamestaRepositoryInterface $radnamestaInterface)
    {
    }

    public function index(){

        $data = $this->radnamestaInterface->getAll();
        return view('kadrovskaevidencija::radnamesta.radnamesta_index', ['data' => $data]);

    }

    public function edit($id){
        $data = $this->radnamestaInterface->getById($id);
        return view('kadrovskaevidencija::radnamesta.radnamesta_edit', ['data' => $data]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);
        $data = $this->radnamestaInterface->update($request->id,$updateData);
        return redirect()->route('radnamesta.index');
    }
}
