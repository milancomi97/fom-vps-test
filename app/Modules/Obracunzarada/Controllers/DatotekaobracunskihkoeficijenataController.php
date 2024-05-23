<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Exports\PoenterUnosExport;
use App\Http\Controllers\Controller;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmAkontacijeRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\UpdateNapomena;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use Illuminate\Http\Request;
use \Carbon\Carbon;
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
        private readonly DpsmPoentazaslogRepositoryInterface                 $dpsmPoentazaslogInterface,
        private readonly DpsmAkontacijeRepositoryInterface                   $dpsmAkontacijeInterface
    )
    {
    }

//    public function show(Request $request)
//    {
//
//        $user_id = auth()->user()->id;
//        $userPermission = UserPermission::where('user_id', $user_id)->first();
//        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
//        $id = $request->radnik_id;
//        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($id);
//        $month_id = $mesecnaTabelaPoentaza->obracunski_koef_id;
//        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($month_id);
//
//
//        $inputDate = Carbon::parse($monthData->datum);
//        $formattedDate = $inputDate->format('m.Y');
//        $vrstePlacanja = $this->vrsteplacanjaInterface->getAll();
//
//        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show',
//            [
//                'monthData' => $formattedDate,
//                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
//                'troskovnaMestaPermission' => $troskovnaMestaPermission,
//                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
//                'vrstePlacanja' => $vrstePlacanja->toJson(),
//                'vrstePlacanjaData' => $mesecnaTabelaPoentaza->vrste_placanja
//            ]);
//    }


//    public function showAll(Request $request)
//    {
//
//        $user_id = auth()->user()->id;
//        $userPermission = UserPermission::where('user_id', $user_id)->first();
//        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
//        $id = $request->month_id;
//        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
//
//        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $id);
//        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);
//        $mesecnaTabelaPoentazaPermissions = $this->pripremiPermisijePoenteriOdobravanja->execute('obracunski_koef_id', $id);
//
//        $inputDate = Carbon::parse($monthData->datum);
//        $formattedDate = $inputDate->format('m.Y');
//
//        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show_all',
//            [
//                'formattedDate' => $formattedDate,
//                'monthData'=>$monthData,
//                'mesecnaTabelaPotenrazaTable' => $mesecnaTabelaPotenrazaTable,
//                'mesecnaTabelaPoentazaPermissions'=>$mesecnaTabelaPoentazaPermissions,
//                'tableHeaders' => $tableHeaders,
//                'vrstePlacanjaDescription'=>$this->vrsteplacanjaInterface->getVrstePlacanjaOpis(),
//                'troskovnaMestaPermission' => $troskovnaMestaPermission,
//                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
//                'userPermission'=>$userPermission
//            ]);
//
//
//    }
//
//    public function showAllAkontacije(Request $request)
//    {
//
//        $user_id = auth()->user()->id;
//        $userPermission = UserPermission::where('user_id', $user_id)->first();
//        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
//        $id = $request->month_id;
//        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
//
//        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTableAkontacije('obracunski_koef_id', $id);
//        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);
//        $mesecnaTabelaPoentazaPermissions = $this->pripremiPermisijePoenteriOdobravanja->execute('obracunski_koef_id', $id);
//
//        $inputDate = Carbon::parse($monthData->datum);
//        $formattedDate = $inputDate->format('m.Y');
//
//        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show_all_akontacije',
//            [
//                'formattedDate' => $formattedDate,
//                'monthData'=>$monthData,
//                'mesecnaTabelaPotenrazaTable' => $mesecnaTabelaPotenrazaTable,
//                'mesecnaTabelaPoentazaPermissions'=>$mesecnaTabelaPoentazaPermissions,
//                'tableHeaders' => $tableHeaders,
//                'vrstePlacanjaDescription'=>$this->vrsteplacanjaInterface->getVrstePlacanjaOpis(),
//                'troskovnaMestaPermission' => $troskovnaMestaPermission,
//                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
//                'userPermission'=>$userPermission
//            ]);
//
//
//    }
//
//    public function showAkontacije(Request $request)
//    {
//
//        $user_id = auth()->user()->id;
//        $userPermission = UserPermission::where('user_id', $user_id)->first();
//        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
//        $id = $request->radnik_id;
//        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($id);
//        $month_id = $mesecnaTabelaPoentaza->obracunski_koef_id;
//        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($month_id);
//
//
//        $inputDate = Carbon::parse($monthData->datum);
//        $formattedDate = $inputDate->format('m.Y');
//        $vrstePlacanja = $this->vrsteplacanjaInterface->getAll();
//        $vrednostAkontacije = collect(json_decode($mesecnaTabelaPoentaza->vrste_placanja,true))->where('key', '061')->first();
//
//        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show_akontacije',
//            [
//                'monthData' => $formattedDate,
//                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
//                'troskovnaMestaPermission' => $troskovnaMestaPermission,
//                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
//                'vrstePlacanja' => $vrstePlacanja->toJson(),
//                'vrstePlacanjaData' => $mesecnaTabelaPoentaza->vrste_placanja,
//                'vrednostAkontacije' =>$vrednostAkontacije,
//                'mesecna_tabela_poentaza_id' =>$mesecnaTabelaPoentaza->id
//            ]);
//
//
//    }
//
//    public function updateAkontacije(Request $request)
//    {
//
//        $id = $request->mesecna_tabela_poentaza_id;
//        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($id);
//
//        $vrednostAkontacije = $request->vrednost_akontacije;
//
//        $vrsteRadaData = json_decode($mesecnaTabelaPoentaza->vrste_placanja,true);
//        foreach ($vrsteRadaData as &$vrstaRada) {
//            // Check if 'KLJUC' is '061'
//            if ($vrstaRada['key'] == '061') {
//                $vrstaRada['iznos'] = (int) $vrednostAkontacije;
//
//            }
//        }
//
//        $mesecnaTabelaPoentaza->vrste_placanja = json_encode($vrsteRadaData);
//        $mesecnaTabelaPoentaza->save();
//
//        return redirect()->route('datotekaobracunskihkoeficijenata.show_all_akontacije', ['month_id' => $mesecnaTabelaPoentaza->obracunski_koef_id]);
//
//    }


    public function odobravanjeExportXls(Request $request)
    {
        $user_id = auth()->user()->id;

        $userPermission = UserPermission::where('user_id', $user_id)->first();

        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
//        $id = $request->month_id; // TODO OVO OBAVEZNO

        $id = '1';

        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);

        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $id);

        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);

        $header = [];
        $radnikData = [];

        foreach ($mesecnaTabelaPotenrazaTable->first() as $radnik) {
            $radnikVrstePlacanja = $radnik['vrste_placanja'];
            $radnikSatiValues = array_column($radnikVrstePlacanja, 'sati');

//            array_unshift($radnikSatiValues,  $radnik['prezime']);
            array_unshift($radnikSatiValues, $radnik['ime']);
            array_unshift($radnikSatiValues, $radnik['maticni_broj']);

            $header[] = $radnikSatiValues;
            $test = "test";
        }

        $headerData = array_column($mesecnaTabelaPotenrazaTable->first()[0]->toArray()['vrste_placanja'], 'name');
        array_unshift($headerData, 'Prezime Ime');
        array_unshift($headerData, 'Maticni broj');

        $test = 'test';
//        foreach ($mesecnaTabelaPotenrazaTable->first() as $radnik){
//            $radnikVrstePlacanja=$radnik['vrste_placanja'];
//            $radnikSatiValues = array_column($radnikVrstePlacanja,'key');
//
//            $header[]= $radnikSatiValues;
//            $test="test";
//        }

        array_unshift($header, $headerData);
        $test = 'testt';

        return Excel::download(new PoenterUnosExport($header), 'data.xlsx');
    }

    public function odobravanjeExportPdf(Request $request)
    {

        $user_id = auth()->user()->id;
        $userPermission = UserPermission::where('user_id', $user_id)->first();
        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
//        $id = $request->month_id; // TODO OVO OBAVEZNO
        $id = '1';
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);

        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $id);
        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);
        $mesecnaTabelaPoentazaPermissions = $this->pripremiPermisijePoenteriOdobravanja->execute('obracunski_koef_id', $id);

        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');
        $vrstePlacanjaDescription = $this->vrsteplacanjaInterface->getVrstePlacanjaOpisPdf();

        $html = '<!DOCTYPE html>
<html lang="' . str_replace('_', '-', app()->getLocale()) . '">
<head>
      <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header, .footer, .footer-potpis {
            background-color: #f1f1f1;
        }
        .header {
            height: 26.4mm;
            line-height: 26.4mm;
            font-size: 6.35mm;
            text-align: center;
            border-width: 0.52mm;
            border-color: #8a8af5;
            border-style: dashed;
            border-bottom-width: 0px;
        }
        .footer {
            height: auto;
            text-align: left;
            line-height: 2.6mm;
            font-size: 2.6mm;
            font-weight: 600;
            border-width: 0.5mm;
            border-color: #8a8af5;
            border-style: dashed;
            border-top-width: 0px;
            border-bottom-width: 0px;
            padding: 2.6mm 0 2.6mm 10mm;

        }



        .content {
            margin: 5.2mm;
            max-width: 261mm;
        }
        .ime_prezime{
        min-width: 61mm;
        text-align:left;
        }
        table {
            border-collapse: collapse;
            page-break-inside: avoid;
            margin-left:2px;
        }

         th {
            border:0.26mm solid #000;
            padding: 1mm;
            text-align: center;
            background-color: #f2f2f2;
        }

         td {
            border:0.26mm solid #000;
            padding: 1mm;
            text-align: center;
        }
        th {
        }
        .fieldValues {
            width: 7.8mm;
            text-align: center;
        }

        .footer-opis-code{
        text-align: left;
         border: none !important;
        }

        .footer-potpis-code{
        text-align: left;
         border: none !important;
        }

        .footer-codes-potpis{
         margin-top: 10mm;
        }

        .footer-potpis-code{
            font-size: 4mm;
            font-weight: 700;
            line-height: 10mm;
        }
    </style>
</head>
<body>';

        foreach ($mesecnaTabelaPotenrazaTable as $key => $organizacionacelina) {
            if (isset($troskovnaMestaPermission[$key]) && $troskovnaMestaPermission[$key]) {
                $html .= '<div class="content">
            <div class="header">
                Organizaciona celina: <b>' . $key . '</b> - ' . $organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta . '
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>';

                foreach ($tableHeaders as $key => $header) {
                    $imePrezimeClass = $key ==2 ? 'ime_prezime' : '';
                    $html .= '<th class"'.$imePrezimeClass.'">' . $header . '</th..>';
                }

                $html .= '</tr>
                </thead>
                <tbody>';

                foreach ($organizacionacelina as $value) {
                    $html .= '<tr>
                        <td>' . $value['maticni_broj'] . '</td>
                        <td class="ime_prezime">' . $value['ime'] . '</td>';

                    foreach ($value['vrste_placanja'] as $vrstaPlacanja) {
                        $html .= '<td class="vrsta_placanja_td"><span class="fieldValues" data-record-id="' . $value['id'] . '" min="0" disabled="disabled" class="vrsta_placanja_input" data-toggle="tooltip" data-placement="top" title="' . $vrstaPlacanja['name'] . '" data-vrsta-placanja-key="' . $vrstaPlacanja['key'] . '" >' . $vrstaPlacanja['sati'] . '</span></td>';
                    }

                    $html .= '</tr>';
                }

                $html .= '</tbody>
            </table>
            <div class="footer">
                        <div class="footer-codes">

'.$vrstePlacanjaDescription.'
            </div>
            <div class="footer-codes-potpis">
'.$this->resolvePotpisPoentaze(json_decode($organizacionacelina[0]->organizacionecelina->odgovorni_direktori_pravila,true)).'
            </div>
            </div>
        </div>';
            }
        }

        $html .= '</body>
</html>';


//        return  response($html, 200)
//            ->header('Content-Type', 'text/html');
        // Load the HTML content
        try {
            $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
//        $pdf = PDF::loadView('materijal_pdf',$filteredData);
            return $pdf->download('pdf_poenteri_'.date("d.m.y").'.pdf');

        } catch (\Throwable $exception) {
//            report("Proveri Formulu:".$vrstaPlacanjaSlog['sifra_vrste_placanja']);
            report($exception);
            $updatedException = new \Exception($exception->getTraceAsString(), $exception->getCode(), $exception);
            throw $updatedException;
        }

    }

    private function resolvePotpisPoentaze($data){
        $html='<div class="footer-potpis-code">';
        foreach ($data as $item) {
            $html .= $item.' <br>';
        }

        $html.='</div>';
        return $html;
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
                'monthData' => $monthData,
                'mesecnaTabelaPotenrazaTable' => $mesecnaTabelaPotenrazaTable,
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

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_create', ['datotekaobracunskihkoeficijenata' => json_encode($data)]);
    }

    public function store(Request $request)
    {

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
            // Poenteri i odgovorna lica permisije odobravanja END

            $idRadnikaZaMesec = $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id', $osnovniPodaciMesec->id)->select(['id', 'maticni_broj'])->get();

            // Poenter Vrsta Placanja START
//            $poenterPlacanja = $this->kreirajObracunskeKoeficienteService->dodeliPocetnaPoenterPlacanja($idRadnikaZaMesec,$osnovniPodaciMesec->mesecni_fond_sati,$osnovniPodaciMesec->id);
//            $akontacijePlacanjaResult = $this->dpsmPoentazaslogInterface->createMany($poenterPlacanja);


            // Poenter Vrsta Placanja  END

            // Akontacije START
//            $akontacijePlacanjaData = $this->kreirajObracunskeKoeficienteService->dodeliPocetneAkontacijePlacanja($idRadnikaZaMesec,$osnovniPodaciMesec->vrednost_akontacije,$osnovniPodaciMesec->id);
//            $akontacijePlacanjaResult = $this->dpsmAkontacijeInterface->createMany($akontacijePlacanjaData);


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
            $status = $this->updateVrstePlacanjaJson->updateSatiByKey($radnikEvidencija, $input_key, $input_value);
        }

        if ($status > 0) {
            $message = 'Podatak je uspesno izmenjen, redovni rad i topli obrok je umanjen';
        } else {
            $message = 'Podatak je uspesno izmenjen';

        }
        return response()->json(['message' => $message, 'status' => true,'negativni_brojac'=>$status,'record_id'=>$record_id], 200);
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
