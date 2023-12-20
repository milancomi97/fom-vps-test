<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\UpdateNapomena;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class DatotekaobracunskihkoeficijenataController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficiente,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly UpdateVrstePlacanjaJson                             $updateVrstePlacanjaJson,
        private readonly UpdateNapomena                                      $updateNapomena,
        private readonly PermesecnatabelapoentRepositoryInterface            $permesecnatabelapoentInterface,
        private readonly KreirajPermisijePoenteriOdobravanja $kreirajPermisijePoenteriOdobravanja,
        private readonly PripremiPermisijePoenteriOdobravanja $pripremiPermisijePoenteriOdobravanja
    )
    {
    }

    public function show(Request $request)
    {

        $user_id = auth()->user()->id;
        $userPermission = UserPermission::where('user_id', $user_id)->first();
        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
        $id = $request->month_id;
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->with('organizacionecelina')->where('obracunski_koef_id', $id)->get();

        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $id);
        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);

        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show',
            [
                'monthData' => $formattedDate,
                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
                'mesecnaTabelaPotenrazaTable' => $mesecnaTabelaPotenrazaTable,
                'tableHeaders' => $tableHeaders,
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all()
            ]);


    }

    public function odobravanje(Request $request)
    {

        $user_id = auth()->user()->id;
        $userPermission = UserPermission::where('user_id', $user_id)->first();
        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
        $id = $request->month_id;
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);

        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $id);
        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);
        $mesecnaTabelaPoentazaPermissions = $this->pripremiPermisijePoenteriOdobravanja->execute('obracunski_koef_id', $id);

        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_odobravanje',
            [
                'formattedDate' => $formattedDate,
                'monthData'=>$monthData,
                'mesecnaTabelaPotenrazaTable' => $mesecnaTabelaPotenrazaTable,
                'mesecnaTabelaPoentazaPermissions'=>$mesecnaTabelaPoentazaPermissions,
                'tableHeaders' => $tableHeaders,
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'userPermission'=>$userPermission
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

        $resultOk = $this->kreirajObracunskeKoeficiente->execute($result);
        $obracunskiKoefId = $result;

        try {
            // Nakon otvaranja meseca, kreira se svakom radniku podatak
            // Pomocna tabela za obracun raznih placanja trenutnog meseca

            $resultDatoteka = $this->mesecnatabelapoentazaInterface->createMany($resultOk);
            // Zatim se otvara pomocna tabela za statuse Odobravanja i evidentiranje poentera.
            // I dodeljuju se Poenteri i Odgvorna lica iz sifarnika
            $resultPMB = $this->kreirajPermisijePoenteriOdobravanja->execute($obracunskiKoefId);
            $resultPermission = $this->permesecnatabelapoentInterface->createMany($resultPMB);

        } catch (\Exception $e) {
            $result->delete();
            return response()->json(['message' => 'Greska kod generisanja obracunskih koeficijenata', 'status' => false], 200);

        }
        return response()->json(['message' => 'Podatak uspesno kreiran', 'status' => true], 200);
    }

    public function getStoreData(Request $request)
    {
        $month = $request['month'];
        $year = $request['year'];
        $startOfMonth = Carbon::create($year, $month, 1);
        $workingDays = $this->datotekaobracunskihkoeficijenataInterface->calculateWorkingHour($startOfMonth);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $workingHours = $workingDays * 8;
        $data = [
            'kalendarski_broj_radnih_dana' => (int)$workingDays,
            'mesecni_fond_sati' => $workingHours,
            'datum' => $startOfMonth,
            'kalendarski_broj_dana' => $endOfMonth->format('d'),
            'status' => 1
        ];

        return response()->json($data);
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

                $message = 'Mesec treba da potvrde odredjene osobe';

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
        if ($input_key == 'napomena') {
            $status = $this->updateNapomena->execute($radnikEvidencija, $input_key, $input_value);

        } elseif ($input_key == 'status_poentaze') {
            $radnikEvidencija->status_poentaze = (int)$input_value;
            $status = $radnikEvidencija->save();
        } else {
            $status = $this->updateVrstePlacanjaJson->execute($radnikEvidencija, $input_key, $input_value);
        }

        if ($status) {
            $message = 'Podatak je uspesno izmenjen';
        } else {
            $message = 'Doslo je do greske';

        }
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function permissionStatusUpdate(Request $request){
        $data = $request->all();
        $status =$this->permesecnatabelapoentInterface->updateStatus($data);
        $message='test';
        return response()->json(['message' => $message, 'status' => true], 200);

    }
}
