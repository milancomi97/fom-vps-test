<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use Illuminate\Http\Request;

class DatotekaobracunskihkoeficijenataController  extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente $kreirajObracunskeKoeficiente,
        private readonly MesecnatabelapoentazaRepositoryInterface $mesecnatabelapoentazaInterface
    )
    {
    }
    public function show(Request $request){

        $id= $request->month_id;
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id',$id);
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show', ['monthData'=>$monthData->toArray(),'mesecnaTabelaPoentaza'=>$mesecnaTabelaPoentaza->toArray()]);


    }

    public function create(){

        $data = $this->datotekaobracunskihkoeficijenataInterface->getAll();
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_create', ['datotekaobracunskihkoeficijenata'=>json_encode($data)]);
    }

    public function store(Request $request){

        try {
            $result = $this->datotekaobracunskihkoeficijenataInterface->createMesecnatabelapoentaza($request->all());
        }
        catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => 'Podatak postoji','status'=>false], 200 );

        }

        if($result->id){
            $test="test";
        }
        $resultOk = $this->kreirajObracunskeKoeficiente->execute($result);

        try {
            $resultDatoteka = $this->mesecnatabelapoentazaInterface->createMany($resultOk);
        } catch (\Exception $e) {
            $result->delete();
            return response()->json(['message' => 'Greska kod generisanja obracunskih koeficijenata','status'=>false], 200 );

        }
        return response()->json(['message' => 'Podatak uspesno kreiran','status'=>true], 200);
    }

}
