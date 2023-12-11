<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class DatotekaobracunskihkoeficijenataController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficiente,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly UpdateVrstePlacanjaJson $updateVrstePlacanjaJson
    )
    {
    }

    public function show(Request $request)
    {

        $id = $request->month_id;
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->with('organizacionecelina')->where('obracunski_koef_id', $id)->get();

        $mesecnaTabelaPotenrazaTable= $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $id);
        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);

        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show',
            [
                'monthData' => $formattedDate,
                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
                'mesecnaTabelaPotenrazaTable'=>$mesecnaTabelaPotenrazaTable,
                'tableHeaders'=>$tableHeaders
            ]);


    }

    public function create()
    {

        $data = $this->datotekaobracunskihkoeficijenataInterface->getAll();
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_create', ['datotekaobracunskihkoeficijenata' => json_encode($data)]);
    }

    public function store(Request $request)
    {

        try {
            $result = $this->datotekaobracunskihkoeficijenataInterface->createMesecnatabelapoentaza($request->all());
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => 'Podatak postoji', 'status' => false], 200);

        }

        if ($result->id) {
            $test = "test";
        }
        $resultOk = $this->kreirajObracunskeKoeficiente->execute($result);

        try {
            $resultDatoteka = $this->mesecnatabelapoentazaInterface->createMany($resultOk);
        } catch (\Exception $e) {
            $result->delete();
            return response()->json(['message' => 'Greska kod generisanja obracunskih koeficijenata', 'status' => false], 200);

        }
        return response()->json(['message' => 'Podatak uspesno kreiran', 'status' => true], 200);
    }

    public function check(Request $request)
    {

        $id = $request->month_id;
        $radniciData = $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id', $id)->get();

        if ($radniciData->count()) {
            $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);


            if ($monthData->status == '1') {

                $message = 'Mesec je otvoren i potrebno je da poenteri unesu podatke za : ' . $radniciData->count() . ' radnika.';

            } else if ($monthData->status == '2') {

                $message = 'Mesec je treba da potvrde odredjene osobe';

            } else if ($monthData->status == '3') {

                $message = 'Mesec je spreman za obradu';

            } else {

                $message = 'Podaci ne postoje, unesi nov mesec';
            }
        }
        $message = 'Podaci ne postoje, unesi nov mesec';

        return response()->json(['message' => $message, 'status' => true], 200);
    }



    public function update(Request $request)
    {
        $input_value = $request->input_value;
        $input_key = $request->input_key;
        $record_id = $request->record_id;
        $radnikEvidencija = $this->mesecnatabelapoentazaInterface->getById($record_id);
        $status = $this->updateVrstePlacanjaJson->execute($radnikEvidencija,$input_key,$input_value);

        if($status){
            $message = 'Podatak je uspesno izmenjen';
        } else{
            $message = 'Doslo je do greske';

        }
        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
