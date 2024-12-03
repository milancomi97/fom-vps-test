<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Exports\PoenterUnosExport;
use App\Http\Controllers\Controller;
use App\Models\Datotekaobracunskihkoeficijenata;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmAkontacijeRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PorezdoprinosiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\MesecValidationService;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\ProveraPoentazeService;
use App\Modules\Obracunzarada\Service\UpdateNapomena;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function Psy\debug;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;


class DatotekaobracunskihkoeficijenataController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficienteService,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly UpdateVrstePlacanjaJson                             $updateVrstePlacanjaJson,
        private readonly UpdateNapomena                                      $updateNapomena,
        private readonly PermesecnatabelapoentRepositoryInterface            $permesecnatabelapoentInterface,
        private readonly KreirajPermisijePoenteriOdobravanja                 $kreirajPermisijePoenteriOdobravanja,
        private readonly PripremiPermisijePoenteriOdobravanja                $pripremiPermisijePoenteriOdobravanja,
        private readonly VrsteplacanjaRepository                             $vrsteplacanjaInterface,
        private readonly ProveraPoentazeService $proveraPoentazeService,
        private readonly MinimalnebrutoosnoviceRepositoryInterface $minimalnebrutoosnoviceInterface,
        private readonly PorezdoprinosiRepositoryInterface                   $porezdoprinosiInterface,

    )
    {
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


        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
//        $radnikCalculated = $this->proveraPoentazeService->kalkulacijaPoRadniku($mesecnaTabelaPotenrazaTable,$vrstePlacanjaSifarnik);
        $troskovniCentarCalculated = $this->proveraPoentazeService->kalkulacijaPoTroskovnomCentru($mesecnaTabelaPotenrazaTable,$vrstePlacanjaSifarnik);

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_odobravanje',
            [
                'formattedDate' => $formattedDate,
                'monthData' => $monthData,
                'mesecnaTabelaPotenrazaTable' => $troskovniCentarCalculated,
                'mesecnaTabelaPoentazaPermissions' => $mesecnaTabelaPoentazaPermissions,
                'tableHeaders' => $tableHeaders,
                'vrstePlacanjaDescription' => $this->vrsteplacanjaInterface->getVrstePlacanjaOpis(),
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'userPermission' => $userPermission
            ]);


    }



    public function odobravanjePoenter(Request $request)
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

        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
        $troskovniCentarCalculated = $this->proveraPoentazeService->kalkulacijaPoTroskovnomCentru($mesecnaTabelaPotenrazaTable,$vrstePlacanjaSifarnik);


        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_odobravanje_poenter',
            [
                'formattedDate' => $formattedDate,
                'monthData' => $monthData,
                'mesecnaTabelaPotenrazaTable' => $troskovniCentarCalculated,
                'mesecnaTabelaPoentazaPermissions' => $mesecnaTabelaPoentazaPermissions,
                'tableHeaders' => $tableHeaders,
                'vrstePlacanjaDescription' => $this->vrsteplacanjaInterface->getVrstePlacanjaOpis(),
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'userPermission' => $userPermission
            ]);


    }

    public function odobravanjeCheckSati(Request $request)
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


        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
//        $radnikCalculated = $this->proveraPoentazeService->kalkulacijaPoRadniku($mesecnaTabelaPotenrazaTable,$vrstePlacanjaSifarnik);
        $troskovniCentarCalculated = $this->proveraPoentazeService->kalkulacijaPoTroskovnomCentru($mesecnaTabelaPotenrazaTable,$vrstePlacanjaSifarnik);

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_odobravanje_check',
            [
                'formattedDate' => $formattedDate,
                'monthData' => $monthData,
                'mesecnaTabelaPotenrazaTable' => $troskovniCentarCalculated,
                'mesecnaTabelaPoentazaPermissions' => $mesecnaTabelaPoentazaPermissions,
                'tableHeaders' => $tableHeaders,
                'vrstePlacanjaDescription' => $this->vrsteplacanjaInterface->getVrstePlacanjaOpis(),
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'userPermission' => $userPermission
            ]);


    }



    public function create()
    {

        $data = $this->datotekaobracunskihkoeficijenataInterface->getAll();

        $activeMonth = $this->datotekaobracunskihkoeficijenataInterface->where('status',Datotekaobracunskihkoeficijenata::AKTUELAN)->first();

        if($activeMonth !==null){
            $date = Carbon::parse($activeMonth->datum);

            $activeMonthValue = $date->month -1 ; // JAVASCRIPT COUNT MONTHS
            $activeYearValue = $date->year;
            $activeMonthExist=true;

        }else{
            $activeMonthExist=false;
            $currentDate = Carbon::now();
            $activeMonthValue = $currentDate->month -1;
            $activeYearValue = $currentDate->year;
            $date = Carbon::parse(\Illuminate\Support\Carbon::createFromFormat('m.Y', $currentDate->month.'.'.$activeYearValue)->format('Y-m-d'));
        }

        $minimalneBrutoOsnovice=$this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth(\Illuminate\Support\Carbon::createFromFormat('m.Y', $activeMonthValue.'.'.$activeYearValue)->format('Y-m-d'));
        $poresDoprinosi = $this->porezdoprinosiInterface->getAll()->first();


        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_create', [
            'datotekaobracunskihkoeficijenata' => json_encode($data),
            'activeMonth'=> $activeMonthValue,
            'activeYear'=>$activeYearValue,
            'activeMonthExist'=>$activeMonthExist,
            'date'=>$date,
            'minimalneBrutoOsnoviceId'=>$minimalneBrutoOsnovice->id,
            'poresDoprinosiId'=>$poresDoprinosi->id

        ]);
    }

    public function store(Request $request)
    {

        // da li je zatvoren prethodni
//        $monthNotClosed = $this->mesecValidationService->checkMonthStatus($request->all());
//        if($monthNotClosed){
//            return response()->json(['message' => 'Prethodni mesec nije arhiviran', 'status' => false], 200);
//        }
        try {
            // Osnovni podaci o otvorenom mesecu
            $osnovniPodaciMesec = $this->datotekaobracunskihkoeficijenataInterface->createMesecnatabelapoentaza($request->all());
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => 'Podatak postoji', 'status' => false], 200);

        }

        try {

            // Podaci o radnicima sa 001 i 019 vrstama plaćanja
            $podaciRadniciMesec = $this->kreirajObracunskeKoeficienteService->otvoriAktivneRadnike($osnovniPodaciMesec);
            $resultDatoteka = $this->mesecnatabelapoentazaInterface->createMany($podaciRadniciMesec);
            // Podaci o radnicima sa 001 i 019 vrstama plaćanja END

            // Poenteri i odgovorna lica permisije odobravanja START
            $resultPMB = $this->kreirajPermisijePoenteriOdobravanja->execute($osnovniPodaciMesec);
            $resultPermission = $this->permesecnatabelapoentInterface->createMany($resultPMB);

            $idRadnikaZaMesec = $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id', $osnovniPodaciMesec->id)->select(['id', 'maticni_broj'])->get();


        } catch (\Exception $e) {
            $osnovniPodaciMesec->delete();
            return response()->json(['message' => 'Greska kod generisanja obracunskih koeficijenata', 'status' => false], 200);

        }
        return response()->json(['message' => 'Podatak uspesno kreiran', 'status' => true], 200);
    }

    public function storeUpdate(Request $request)
    {

        try {
            $result = $this->datotekaobracunskihkoeficijenataInterface->updateMesecnatabelapoentaza($request->all());
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => 'Podatak postoji', 'status' => false], 200);

        }

        $resultOk = $this->kreirajObracunskeKoeficienteService->otvoriAktivneRadnike($result);
        $obracunskiKoefId = $result;

        try {
            $resultDatoteka = $this->mesecnatabelapoentazaInterface->createMany($resultOk);
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

//    public function check(Request $request)
//    {
//
//        $id = $request->month_id;
//        $radniciData = $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id', $id)->get();
//
//        if ($radniciData->count()) {
//            $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
//
//
//            if ($monthData->status == '1') {
//
//                $message = 'Mesec je otvoren i potrebno je da poenteri unesu podatke za : ' . $radniciData->count() . ' radnika.';
//
//            } else if ($monthData->status == '2') {
//
//                $message = 'Mesec treba da potvrde odredjene osobe';
//
//            } else if ($monthData->status == '3') {
//
//                $message = 'Mesec je spreman za obradu';
//
//            } else {
//
//                $message = 'Podaci ne postoje, unesi nov mesec';
//            }
//        }
//        $message = 'Podaci ne postoje, unesi nov mesec';
//
//        return response()->json(['message' => $message, 'status' => true], 200);
//    }


    public function update(Request $request)
    {
        $input_value = $request->input_value;
        $input_key = $request->input_key;
        $record_id = $request->record_id;


        $radnikEvidencija = $this->mesecnatabelapoentazaInterface->getById($record_id);



        Log::channel('evidencija_dodavanja_poentera')->debug('Poenter: '.Auth::user()->prezime .' '.Auth::user()->ime .' dodao_vrste_placanja: '.$input_key . ' sati: '.$input_value.' Radniku: '.$radnikEvidencija->maticni_broj  .' '.$radnikEvidencija->prezime .' '.$radnikEvidencija->ime);

        if ($input_key == 'napomena') {
            $result = $this->updateNapomena->execute($radnikEvidencija, $input_key, $input_value);
            $action = 'napomenaUpdated';

        } elseif ($input_key == 'status_poentaze') {
            $radnikEvidencija->status_poentaze = (int)$input_value;
            $result = $radnikEvidencija->save();
            $action='statusUpdated';
        } else {
            $result = $this->updateVrstePlacanjaJson->updateSatiByKey($radnikEvidencija, $input_key, $input_value);
            $action='vrstePlacanjaUpdated';
        }


        return response()->json(['action'=>$action,'result'=>$result,'record_id'=>$record_id], 200);
    }
//
//    public function updateAll(Request $request)
//    {
//        $vrstePlacanjaData = $request->vrste_placanja;
//        $record_id =$request->record_id;
//        $radnikEvidencija = $this->mesecnatabelapoentazaInterface->getById($record_id);
//        $status = $this->updateVrstePlacanjaJson->updateAll($radnikEvidencija,$vrstePlacanjaData);
//
//        if($status){
//            $message='uspesno promenjen';
//            return response()->json(['message' => $message, 'status' => true], 200);
//
//        }
//        $message='greska';
//        return response()->json(['message' => $message, 'status' => false], 200);
//    }


    public function getMonthDataById(Request $request)
    {

        $data = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        return response()->json($data);
    }


}
