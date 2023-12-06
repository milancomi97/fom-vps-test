<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use Illuminate\Http\Request;

class DatotekaobracunskihkoeficijenataController  extends Controller
{
    public function __construct(private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface)
    {
    }

    public function create(){

        $data = $this->datotekaobracunskihkoeficijenataInterface->getAll();
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_create', ['datotekaobracunskihkoeficijenata'=>json_encode($data)]);
    }

    public function store(Request $request){

        try {
            $status = $this->datotekaobracunskihkoeficijenataInterface->createMesecnatabelapoentaza($request->all());
        }
        catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => 'Podatak postoji','status'=>false], 200 );

        }

        if($status->id){
            $test="test";

        }
        return response()->json(['message' => 'Podatak uspesno kreiran','status'=>true], 200);
    }

}
