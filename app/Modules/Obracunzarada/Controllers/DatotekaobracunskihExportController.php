<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Exports\PoenterUnosExport;
use App\Http\Controllers\Controller;
use App\Mail\DemoMail;
use App\Models\UserPermission;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\KreditoriRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Service\ObradaObracunavanjeService;
use App\Modules\Obracunzarada\Service\ProveraPoentazeService;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use function Psy\debug;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;


class DatotekaobracunskihExportController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly VrsteplacanjaRepository                             $vrsteplacanjaInterface,
        private readonly ProveraPoentazeService $proveraPoentazeService,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface       $obradaDkopSveVrstePlacanjaInterface,
        private readonly ObradaZaraPoRadnikuRepositoryInterface              $obradaZaraPoRadnikuInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface,
        private readonly  MinimalnebrutoosnoviceRepositoryInterface $minimalnebrutoosnoviceInterface,
        private readonly ObradaObracunavanjeService                          $obradaObracunavanjeService,
        private readonly PodaciofirmiRepositoryInterface                     $podaciofirmiInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly ObradaKreditiRepositoryInterface $obradaKreditiInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface       $dkopSveVrstePlacanjaInterface,
        private readonly KreditoriRepositoryInterface $kreditoriInterface,
        private readonly DpsmKreditiRepositoryInterface                      $dpsmKreditiInterface,






    )
    {
    }


    public function odobravanjeExportXls(Request $request)
    {
        $user_id = auth()->user()->id;

        $userPermission = UserPermission::where('user_id', $user_id)->first();

        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
//        $id = $request->month_id; // TODO OVO OBAVEZNO
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
        $celineZaStampu = $request->approved_org_celine;
        $monthId = $request->month_id;
        $orgCelineRequestData = json_decode($celineZaStampu,true);
        $orgCelineRequestArray = !is_array($orgCelineRequestData) ? [$orgCelineRequestData] : $orgCelineRequestData;

        $celineZaStampuData =[];
        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $monthId);

        foreach ($orgCelineRequestArray as $ogCelinaId){

            $celineZaStampuData[$ogCelinaId]=$mesecnaTabelaPotenrazaTable[$ogCelinaId];
        }

        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
        $troskovniCentarCalculated = $this->proveraPoentazeService->kalkulacijaPoTroskovnomCentru($celineZaStampuData,$vrstePlacanjaSifarnik);
        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);

        $organizacioneCelineSifarnik = $this->organizacionecelineInterface->getAll()->keyBy('id');
        $rows = [];
        for ($i=0;$i<200;$i++) {
            $rows[] = ['column1' => '0002222', 'column2' => 'Prezime SR Imeeee', 'column3' => '123', 'column4' => '123', 'column5' => '123', 'column6' => '123', 'column7' => '123', 'column8' => '123', 'column9' => '123', 'column10' => '123', 'column11' => '123', 'column12' => '123', 'column13' => '123', 'column14' => '123', 'column15' => '123', 'column16' => '123', 'column17' => '123', 'column18' => '123', 'column19' => '123', 'column20' => '123', 'column21' => '123', 'column22' => '123'];
        }
//        return view('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
//            [
//                'rows'=>$rows
//            ]);
        $vrstePlacanjaDescription = $this->vrsteplacanjaInterface->getVrstePlacanjaOpisPdf();

//        return view('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
//            [
//                'rows'=>$rows,
//                'data'=>$troskovniCentarCalculated,
//                'tableHeaders'=>$tableHeaders,
//                'vrstePlacanjaDescription'=>$vrstePlacanjaDescription,
//                'organizacioneCelineSifarnik'=>$organizacioneCelineSifarnik
//            ]
//        );
        set_time_limit(0);
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();



//        return view('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
//            [
//                'rows'=>$rows,
//                'data'=>$troskovniCentarCalculated,
//                'tableHeaders'=>$tableHeaders,
//                'vrstePlacanjaDescription'=>$vrstePlacanjaDescription,
//                'organizacioneCelineSifarnik'=>$organizacioneCelineSifarnik,
//                'podaciFirme' => $podaciFirme,
//            ]
//        );



        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);

        $podaciMesec->datum=date('m.Y', strtotime($podaciMesec->datum));
        ini_set('memory_limit', '2048M');
        set_time_limit(0);


//        return view('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
//            [
//                'rows'=>$rows,
//                'data'=>$troskovniCentarCalculated,
//                'tableHeaders'=>$tableHeaders,
//                'vrstePlacanjaDescription'=>$vrstePlacanjaDescription,
//                'organizacioneCelineSifarnik'=>$organizacioneCelineSifarnik,
//                'podaciFirme' => $podaciFirme,
//                'podaciMesec'=>$podaciMesec
//
//            ]
//        );

        $pdf = PDF::loadView('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
            [
                'rows'=>$rows,
                'data'=>$troskovniCentarCalculated,
                'tableHeaders'=>$tableHeaders,
                'vrstePlacanjaDescription'=>$vrstePlacanjaDescription,
                'organizacioneCelineSifarnik'=>$organizacioneCelineSifarnik,
                'podaciFirme' => $podaciFirme,
                'podaciMesec'=>$podaciMesec
            ]
        )->setPaper('a4', 'portrait');
        // TODO Test
        return $pdf->download('pdf_poenteri_'.date("d.m.y").'.pdf');

    }

    public function odobravanjeExportExcel(Request $request)
    {
        $celineZaStampu = $request->approved_org_celine;
        $monthId = $request->month_id;
        $orgCelineRequestData = json_decode($celineZaStampu,true);
        $orgCelineRequestArray = !is_array($orgCelineRequestData) ? [$orgCelineRequestData] : $orgCelineRequestData;

        $celineZaStampuData =[];
        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $monthId);

        foreach ($orgCelineRequestArray as $ogCelinaId){

            $celineZaStampuData[$ogCelinaId]=$mesecnaTabelaPotenrazaTable[$ogCelinaId];
        }

        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
//        $troskovniCentarCalculated = $this->proveraPoentazeService->kalkulacijaPoTroskovnomCentru($celineZaStampuData,$vrstePlacanjaSifarnik);
        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);

        // todo $tableHeaders zaglavlja
        $organizacioneCelineSifarnik = $this->organizacionecelineInterface->getAll()->keyBy('id');


//        return view('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
//            [
//                'rows'=>$rows
//            ]);
        $vrstePlacanjaDescription = $this->vrsteplacanjaInterface->getVrstePlacanjaOpisPdf();

        $excelData =[];
        $excelData[]=$tableHeaders;
        foreach ($celineZaStampuData as $key=>$celina){
            $excelData[]=[$key,$organizacioneCelineSifarnik[$key]->naziv_troskovnog_mesta,'','','','','','','','','',];
            foreach ($celina as $key2=>$radnik){

                $radnikData=[];
                $radnikSati = array_column($radnik->vrste_placanja,'sati');

                array_unshift($radnikSati, $radnik->ime);
                array_unshift($radnikSati, $radnik->maticni_broj);

                $excelData[]=$radnikSati;
                $test='test';


            }
            $excelData[]=['','','','','','','','','','','','','',''];
        }

        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);
        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');
//
//        $test='test';
        return Excel::download(new PoenterUnosExport($excelData), 'poentaza_'.$formattedDate.'.xlsx');

    }
    public function stampaRadnikLista(Request $request){


//          $pdf = PDF::loadView('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
//              [
//                  'rows'=>$rows,
//                  'data'=>$troskovniCentarCalculated,
//                  'tableHeaders'=>$tableHeaders,
//                  'vrstePlacanjaDescription'=>$vrstePlacanjaDescription,
//                  'organizacioneCelineSifarnik'=>$organizacioneCelineSifarnik
//              ]
//          )->setPaper('a4', 'portrait');
//
//        return $pdf->download('pdf_poenteri_'.date("d.m.y").'.pdf');
        $monthId = $request->month_id;

        $radnikMaticniId=$request->radnik_maticni;

//        (($podaci o firmi) ULICA OPSTINA PIB RACUN BANKE
//        Za mesec: 03.2024.(($formatirajDatum))
//        (($Ulica broj)) $((Grad)) //PREBACI LOGIKU U MDR da ne povlacis podatke
//        (($Naziv banke (tabela isplatnamesta->rbim_sifra_isplatnog_mesta == $mdrData['RBIM_isplatno_mesto_id'])) 03-001-10113/4}
//((Strucna sprema: $mdrData['RBPS_priznata_strucna_sprema'] treba logika da se izvuce))
//Radno mesto $mdrData['RBRM_radno_mesto'] treba logika da se izvuce naziv))


        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();

        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);


        $radnikData = $this->obradaObracunavanjeService->pripremaPodatakaRadnik($monthId,$radnikMaticniId);

        $mdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$radnikMaticniId)->get()->first();

        $mdrDataCollection = collect($mdrData);
        $mdrPreparedData = $this->obradaObracunavanjeService->pripremaMdrPodatakaRadnik($mdrDataCollection);

        $troskovnoMesto = $this->organizacionecelineInterface->getById($mdrDataCollection['troskovno_mesto_id']);
        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();

        $date = new \DateTime($podaciMesec->datum);
        $formattedDate = $date->format('m.Y');

        $dkopData = $this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get();


        $zarData = $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get()->first();
        $datumStampe = Carbon::now()->format('d. m. Y.');
        $kreditiData = $this->obradaKreditiInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get();
        $userData= User::where('maticni_broj',$radnikMaticniId)->first();

        set_time_limit(0);



        $pdf = PDF::loadView('obracunzarada::izvestaji.obracunzarada_show_plate_export_pdf',
            [
                'radnikData' => $radnikData,
                'userData'=>$userData,
                'vrstePlacanjaData' => $sifarnikVrstePlacanja,
                'mdrData' => $mdrData,
                'podaciFirme' => $podaciFirme,
                'mdrPreparedData' => $mdrPreparedData,
                'dkopData' => $dkopData,
                'zarData' => $zarData,
                'kreditiData'=>$kreditiData,
                'datum' => $formattedDate,
                'podaciMesec' => $podaciMesec,
                'troskovnoMesto'=> $troskovnoMesto,
                'datumStampe'=>$datumStampe,
                'month_id'=>$request->month_id
//                'zaraData'=>$zaraData
            ])->setPaper('a4', 'portrait');

        $test='test';

//        Mail::to('snezat@gmail.com')->send(new DemoMail($mailData));
//        $mailData = [
//            'title' => 'Naslov',
//            'body' => 'Sadrzaj',
//            'subject'=>'Obračunski list: '.$radnikMaticniId,
//            'pdf'=>$pdf->output()
//        ];
////        Mail::to('snezat@gmail.com')->send(new DemoMail($mailData));
//
//
//        Mail::to('dimitrijevicm1997@gmail.com')->send(new DemoMail($mailData));
//
//        return $pdf->output();
        return $pdf->download('pdf_radnik_lista_'.$radnikMaticniId.'_'.date("d.m.y").'.pdf');


        return view('obracunzarada::izvestaji.obracunzarada_show_plate_export_pdf',
            [
                'radnikData' => $radnikData,
                'userData'=>$userData,
                'vrstePlacanjaData' => $sifarnikVrstePlacanja,
                'mdrData' => $mdrData,
                'podaciFirme' => $podaciFirme,
                'mdrPreparedData' => $mdrPreparedData,
                'dkopData' => $dkopData,
                'zarData' => $zarData,
                'kreditiData'=>$kreditiData,
                'datum' => $formattedDate,
                'podaciMesec' => $podaciMesec,
                'troskovnoMesto'=> $troskovnoMesto,
                'datumStampe'=>$datumStampe,
                'month_id'=>$request->month_id
//                'zaraData'=>$zaraData
            ]);



    }




    public function stampaRadnikListaAll(Request $request)
    {


//          $pdf = PDF::loadView('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
//              [
//                  'rows'=>$rows,
//                  'data'=>$troskovniCentarCalculated,
//                  'tableHeaders'=>$tableHeaders,
//                  'vrstePlacanjaDescription'=>$vrstePlacanjaDescription,
//                  'organizacioneCelineSifarnik'=>$organizacioneCelineSifarnik
//              ]
//          )->setPaper('a4', 'portrait');
//
//        return $pdf->download('pdf_poenteri_'.date("d.m.y").'.pdf');
        $monthId = $request->month_id;

        $radnikMaticniId = $request->radnik_maticni;

//        (($podaci o firmi) ULICA OPSTINA PIB RACUN BANKE
//        Za mesec: 03.2024.(($formatirajDatum))
//        (($Ulica broj)) $((Grad)) //PREBACI LOGIKU U MDR da ne povlacis podatke
//        (($Naziv banke (tabela isplatnamesta->rbim_sifra_isplatnog_mesta == $mdrData['RBIM_isplatno_mesto_id'])) 03-001-10113/4}
//((Strucna sprema: $mdrData['RBPS_priznata_strucna_sprema'] treba logika da se izvuce))
//Radno mesto $mdrData['RBRM_radno_mesto'] treba logika da se izvuce naziv))


        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();

        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);


        $allData = [];
        $zarDataKeys = $this->obradaZaraPoRadnikuInterface->getAll();
        $date = new \DateTime($podaciMesec->datum);
        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();
        $formattedDate = $date->format('m.Y');
        $datumStampe = Carbon::now()->format('d. m. Y.');

        $counter = 0;
        foreach ($zarDataKeys as $zar) {
            $counter++;

            if ($counter < 150) {
                $radnikMaticniId = $zar->maticni_broj;
                $radnikData = $this->obradaObracunavanjeService->pripremaPodatakaRadnik($monthId, $radnikMaticniId);
                $mdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj', $radnikMaticniId)->get()->first();
                $mdrDataCollection = collect($mdrData);
                $mdrPreparedData = $this->obradaObracunavanjeService->pripremaMdrPodatakaRadnik($mdrDataCollection);
                $troskovnoMesto = $this->organizacionecelineInterface->getById($mdrDataCollection['troskovno_mesto_id']);
                $dkopData = $this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get();
                $zarData = $this->obradaZaraPoRadnikuInterface->where('maticni_broj', $mdrData->MBRD_maticni_broj)->get()->first();
                $kreditiData = $this->obradaKreditiInterface->where('maticni_broj', $mdrData->MBRD_maticni_broj)->get();
                $userData = User::where('maticni_broj', $radnikMaticniId)->first();

                $allData[] = [
                    'radnikData' => $radnikData,
                    'mdrData' => $mdrData,
                    'mdrPreparedData' => $mdrPreparedData,
                    'troskovnoMesto' => $troskovnoMesto,
                    'dkopData' => $dkopData,
                    'kreditiData' => $kreditiData,
                    'userData' => $userData,
                    'zarData' => $zarData
                ];

            }


        }


        set_time_limit(0);


        try {

        $pdf = PDF::loadView('obracunzarada::izvestaji.obracunzarada_show_plate_export_all_pdf',
            [
//                'mdrData' => $mdrData,
//                'userData'=>$userData,
//                'radnikData' => $radnikData,
//                'mdrPreparedData' => $mdrPreparedData,
//                'dkopData' => $dkopData,
//                'zarData' => $zarData,
//                'kreditiData'=>$kreditiData,
//                'troskovnoMesto'=> $troskovnoMesto,
                'vrstePlacanjaData' => $sifarnikVrstePlacanja,
                'datum' => $formattedDate,
                'podaciFirme' => $podaciFirme,
                'podaciMesec' => $podaciMesec,
                'datumStampe' => $datumStampe,
                'month_id' => $request->month_id,
                'allData' => $allData
            ])->setPaper('a4', 'portrait');

        }catch(\Exception $message){

            $tes='test';


            $test='test';
}
        $test='test';

//        Mail::to('snezat@gmail.com')->send(new DemoMail($mailData));
//        $mailData = [
//            'title' => 'Naslov',
//            'body' => 'Sadrzaj',
//            'subject'=>'Obračunski list: '.$radnikMaticniId,
//            'pdf'=>$pdf->output()
//        ];
////        Mail::to('snezat@gmail.com')->send(new DemoMail($mailData));
//
//
//        Mail::to('dimitrijevicm1997@gmail.com')->send(new DemoMail($mailData));
//
//        return $pdf->output();
        return $pdf->stream('pdf_radnik_lista_svi_radnici_'.date("d.m.y").'.pdf');


        return view('obracunzarada::izvestaji.obracunzarada_all_show_plate_export_pdf',
            [
                'radnikData' => $radnikData,
                'userData'=>$userData,
                'vrstePlacanjaData' => $sifarnikVrstePlacanja,
                'mdrData' => $mdrData,
                'podaciFirme' => $podaciFirme,
                'mdrPreparedData' => $mdrPreparedData,
                'dkopData' => $dkopData,
                'zarData' => $zarData,
                'kreditiData'=>$kreditiData,
                'datum' => $formattedDate,
                'podaciMesec' => $podaciMesec,
                'troskovnoMesto'=> $troskovnoMesto,
                'datumStampe'=>$datumStampe,
                'month_id'=>$request->month_id
//                'zaraData'=>$zaraData
            ]);



    }



    public function stampaRangListeExcel(Request $request)
    {
        $user_id = auth()->user()->id;

        $userPermission = UserPermission::where('user_id', $user_id)->first();

        $obracunskiKoeficijentId = $request->month_id;

        $dkopData =$this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id',$obracunskiKoeficijentId)->get();
        $zaraData =  $this->obradaZaraPoRadnikuInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id',$obracunskiKoeficijentId)->get()->sortByDesc('IZNETO_zbir_ukupni_iznos_naknade_i_naknade');

        $orgCelineData = $this->organizacionecelineInterface->getAll()->mapWithKeys(function($orgCelina){
            return [
                $orgCelina->id=>$orgCelina->toArray()
            ];
        });
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($monthData->datum);
        $groupedZara = $zaraData->map(function($zaraRadnik) use($orgCelineData){
            $zaraRadnik['org_celina_data']= $orgCelineData[$zaraRadnik['organizaciona_celina_id']];
            return $zaraRadnik;
        })->sortBy('organizaciona_celina_id')->groupBy('organizaciona_celina_id');

        $strucneKvalifikacijeSifarnik =  $this->strucnakvalifikacijaInterface->getAllKeySifra();
//        $groupedZara // TODO ovo koristim
        // TODO DOVDE JE LOGIKA SA PODACIMA

        $excelData = [];
        //        $id = $request->month_id; // TODO OVO OBAVEZNO

// TODO OVO OBAVEZNO

        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($obracunskiKoeficijentId);
        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $obracunskiKoeficijentId);

        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);


        $header = [
            'Sifra TC',
            'MB',
            'Prezime i ime',
            'Kvalifikacija',
            'Osnovna',
            'SATI',
            'BRUTO ZARADA',
            'NETO ZARADA',
            'REDOVNI RAD',
            'PREKOVREMENI RAD',
            'MINULI RAD',
            'TOPLI OBROK',
            'ZA ISPLATU'
        ];

        $radnikData = [];
        $radnikData[]=$header;
        foreach ($groupedZara as $key=>$celinaZara){

            $test='test';
                    $brojaCKOEF_osnovna_zarada=0;
                    $brojaCUKSA_ukupni_sati_za_isplatu=0;
                    $brojaCIZNETO_zbir_ukupni_iznos_naknade_i_naknade=0;
                    $brojaCNETO_neto_zarada=0;
                    $brojaCEFIZNO_kumulativ_iznosa_za_efektivne_sate=0;
                    $brojaCBMIN_prekovremeni_iznos=0;
                    $brojaCvarijab=0;
                    $brojaCTOPLI_obrok_iznos=0;
                    $brojacZaIsplatu=0;
            $radnikData[]=[$key.' - '.$orgCelineData[$key]['naziv_troskovnog_mesta'],'','','','','','',];

            foreach ($celinaZara as $radnik){
                $radnikData[] = [
                    $radnik->sifra_troskovnog_mesta,
                    $radnik->maticni_broj,
                    $radnik->prezime . ' ' . $radnik->srednje_ime . ' ' . $radnik->ime,
                    $strucneKvalifikacijeSifarnik[$radnik->maticnadatotekaradnika->RBPS_priznata_strucna_sprema]['skraceni_naziv_kvalifikacije'] ?? '',
                    $radnik->maticnadatotekaradnika->KOEF_osnovna_zarada,
                    $radnik->UKSA_ukupni_sati_za_isplatu,
                    $radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade,
                    $radnik->NETO_neto_zarada,
                    $radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate / $minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,
                    $radnik->BMIN_prekovremeni_iznos,
                    $radnik->varijab,
                    $radnik->TOPLI_obrok_iznos / $minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,
                    $radnik->NETO_neto_zarada - $radnik->SIOB_ukupni_iznos_obustava - $radnik->ZARKR_ukupni_zbir_kredita
                ];

                    $brojaCKOEF_osnovna_zarada+=$radnik->maticnadatotekaradnika->KOEF_osnovna_zarada;
                    $brojaCUKSA_ukupni_sati_za_isplatu+=$radnik->UKSA_ukupni_sati_za_isplatu;
                    $brojaCIZNETO_zbir_ukupni_iznos_naknade_i_naknade+= $radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade;
                    $brojaCNETO_neto_zarada+=$radnik->NETO_neto_zarada;
                    $brojaCEFIZNO_kumulativ_iznosa_za_efektivne_sate+=$radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate / $minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                    $brojaCBMIN_prekovremeni_iznos+=$radnik->BMIN_prekovremeni_iznos;
                    $brojaCvarijab+=$radnik->varijab;
                    $brojaCTOPLI_obrok_iznos+=$radnik->TOPLI_obrok_iznos / $minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                    $brojacZaIsplatu+=$radnik->NETO_neto_zarada - $radnik->SIOB_ukupni_iznos_obustava - $radnik->ZARKR_ukupni_zbir_kredita;
            }


            $radnikData[]=['UKUPNO:','','','',$brojaCKOEF_osnovna_zarada,$brojaCUKSA_ukupni_sati_za_isplatu,$brojaCIZNETO_zbir_ukupni_iznos_naknade_i_naknade,$brojaCNETO_neto_zarada,$brojaCEFIZNO_kumulativ_iznosa_za_efektivne_sate,$brojaCBMIN_prekovremeni_iznos,$brojaCvarijab,$brojaCTOPLI_obrok_iznos,$brojaCNETO_neto_zarada];
            $radnikData[]=['***************','***************','***************','***************','***************','***************','***************','***************','***************','***************','***************','***************'];
        }

        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');

        $test='test';
        return Excel::download(new PoenterUnosExport($radnikData), $formattedDate.'_rang_lista_bruto_zarada.xlsx');
    }
    public function stampaRangListe(Request $request){

        $obracunskiKoeficijentId = $request->month_id;

        $dkopData =$this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id',$obracunskiKoeficijentId)->get();
        $zaraData =  $this->obradaZaraPoRadnikuInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id',$obracunskiKoeficijentId)->orderBy('UKUPNO','desc')->get();

        $orgCelineData = $this->organizacionecelineInterface->getAll()->mapWithKeys(function($orgCelina){
            return [
                $orgCelina->id=>$orgCelina->toArray()
            ];
        });
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($monthData->datum);
        $groupedZara = $zaraData->map(function($zaraRadnik) use($orgCelineData){
            $zaraRadnik['org_celina_data']= $orgCelineData[$zaraRadnik['organizaciona_celina_id']];
            return $zaraRadnik;
        })->sortBy('organizaciona_celina_id')->groupBy('organizaciona_celina_id');

        $strucneKvalifikacijeSifarnik =  $this->strucnakvalifikacijaInterface->getAllKeySifra();

//        return view('obracunzarada::izvestaji.ranglista_zarade_export_pdf',
//            ['groupedZara'=>$groupedZara,'strucneKvalifikacijeSifarnik'=>$strucneKvalifikacijeSifarnik,'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]);

        set_time_limit(0);
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($obracunskiKoeficijentId);

        $podaciMesec->datum=date('m.Y', strtotime($podaciMesec->datum));
//
//        return view('obracunzarada::izvestaji.ranglista_zarade_export_pdf',
//            [
//                'podaciFirme'=>$podaciFirme,
//                'podaciMesec'=>$podaciMesec,
//                'groupedZara'=>$groupedZara,
//                'strucneKvalifikacijeSifarnik'=>$strucneKvalifikacijeSifarnik,
//                'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]
//        );


        $pdf = PDF::loadView('obracunzarada::izvestaji.ranglista_zarade_export_pdf',
            [
                'podaciFirme'=>$podaciFirme,
                'podaciMesec'=>$podaciMesec,
                'groupedZara'=>$groupedZara,
                'strucneKvalifikacijeSifarnik'=>$strucneKvalifikacijeSifarnik,
                'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]
        )->setPaper('a4', 'portrait');

        return $pdf->download('pdf_rang_lista_'.date("d.m.y").'.pdf');

    }

    public function stampaOstvareneZarade(Request $request){
        //Rekapitulacija Ostvarene Zarade
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($monthData->datum);
        $obracunskiKoeficijentId = $request->month_id;

        $dkopData =$this->obradaDkopSveVrstePlacanjaInterface
            ->where('obracunski_koef_id',$obracunskiKoeficijentId)
            ->orderBy('sifra_vrste_placanja')
            ->groupBy('sifra_vrste_placanja','naziv_vrste_placanja')
            ->selectRaw('sifra_vrste_placanja,naziv_vrste_placanja, SUM(iznos) as iznos, SUM(sati) as sati')
            ->get();


        $zaraData =$this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id',$obracunskiKoeficijentId)
            ->selectRaw('
        SUM(IZNETO_zbir_ukupni_iznos_naknade_i_naknade) AS IZNETO_zbir_ukupni_iznos_naknade_i_naknade,
        SUM(SID_ukupni_iznos_doprinosa) AS SID_ukupni_iznos_doprinosa,
        SUM(SIP_ukupni_iznos_poreza) AS SIP_ukupni_iznos_poreza,
        SUM(SIOB_ukupni_iznos_obustava) AS SIOB_ukupni_iznos_obustava,
        SUM(ZARKR_ukupni_zbir_kredita) AS ZARKR_ukupni_zbir_kredita,
        SUM(POROSL_poresko_oslobodjenje) AS POROSL_poresko_oslobodjenje,
        SUM(NETO_neto_zarada) AS NETO_neto_zarada,
        SUM(PIOR_penzijsko_osiguranje_na_teret_radnika) AS PIOR_penzijsko_osiguranje_na_teret_radnika,
        SUM(ZDRR_zdravstveno_osiguranje_na_teret_radnika) AS ZDRR_zdravstveno_osiguranje_na_teret_radnika,
        SUM(ONEZR_osiguranje_od_nezaposlenosti_teret_radnika) AS ONEZR_osiguranje_od_nezaposlenosti_teret_radnika,
        SUM(PIOP_penzijsko_osiguranje_na_teret_poslodavca) AS PIOP_penzijsko_osiguranje_na_teret_poslodavca,
        SUM(ZDRP_zdravstveno_osiguranje_na_teret_poslodavca) AS ZDRP_zdravstveno_osiguranje_na_teret_poslodavca
    ')->first();


        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();

        set_time_limit(0);
//        return view('obracunzarada::izvestaji.rekapitulacija_zarade_export_pdf',
//            ['dkopData'=>$dkopData,'zaraData'=>$zaraData,'vrstePlacanjaSifarnik'=>$vrstePlacanjaSifarnik,'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]);

        $zaraUkupno =$this->obradaZaraPoRadnikuInterface->getAll();

        $date = new \DateTime($monthData->datum);
        $datum = $date->format('m.Y');

        $radnikaSaZaradom=$this->obradaZaraPoRadnikuInterface->whereCondition('IZNETO_zbir_ukupni_iznos_naknade_i_naknade','>',0)->get();
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $datumStampe = Carbon::now()->format('d. m. Y.');

        $pdf = PDF::loadView('obracunzarada::izvestaji.rekapitulacija_zarade_export_pdf',
            [
                'dkopData'=>$dkopData,
                'zaraData'=>$zaraData,
                'vrstePlacanjaSifarnik'=>$vrstePlacanjaSifarnik,
                'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik,
                'aktivnihRadnika'=>$zaraUkupno->count(),
                'radnikaSaZaradom'=>$radnikaSaZaradom->count(),
                'datum'=>$datum,
                'podaciFirme'=>$podaciFirme,
                'datumStampe'=>$datumStampe

            ])->setPaper('a4', 'portrait');

        return $pdf->download('pdf_ostvarene_zarade_'.date("d.m.y").'.pdf');



        return view('obracunzarada::izvestaji.rekapitulacija_zarade_export_pdf',
            ['dkopData'=>$dkopData,'zaraData'=>$zaraData,'vrstePlacanjaSifarnik'=>$vrstePlacanjaSifarnik,'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]);
    }



    public function stampaPoVrstiPlacanja(Request $request)
    {

        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $sifraVrstePlacanja = $request->vrsta_placanja;
        $dkopData = $this->obradaDkopSveVrstePlacanjaInterface->where('sifra_vrste_placanja',$sifraVrstePlacanja)->where('obracunski_koef_id',$request->month_id)->orderBy('iznos', 'desc')
            ->orderBy('sati', 'desc')->get();


        $updatedDkopData =  $dkopData->map(function ($dkop){
            $dkop['mdrData']=$this->maticnadatotekaradnikaInterface->getById($dkop->user_mdr_id);
            return $dkop;
        });
        $date = new \DateTime($monthData->datum);
        $datum = $date->format('m.Y');
        set_time_limit(0);

        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);


//        return view('obracunzarada::izvestaji.datotekaobracunskihkoeficijenata_exportpdf_po_vrsti_placanja',[
//            'month_id'=>$request->month_id,
//            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
//            'dkopData'=>$updatedDkopData,
//            'datum'=>$datum,
//            'podaciFirme'=>$podaciFirme,
//            'podaciMesec'=>$podaciMesec
//        ]);
        $podaciMesec->datum=date('m.Y', strtotime($podaciMesec->datum));
        $pdf = PDF::loadView('obracunzarada::izvestaji.datotekaobracunskihkoeficijenata_exportpdf_po_vrsti_placanja',[
            'month_id'=>$request->month_id,
            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
            'dkopData'=>$updatedDkopData,
            'datum'=>$datum,
            'podaciFirme'=>$podaciFirme,
            'podaciMesec'=>$podaciMesec
        ])->setPaper('a4', 'portrait');

        set_time_limit(0);


        return $pdf->download('pdf_'.$sifraVrstePlacanja.'_'.date("d.m.y").'.pdf');
    }


public function stampaPoVrstiPlacanjaAlimentacija(Request $request)
{

    $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
    $sifraVrstePlacanja = $request->vrsta_placanja;
    $dkopData = $this->obradaDkopSveVrstePlacanjaInterface
        ->whereIn('sifra_vrste_placanja', ['502', '503','504'])
        ->where('obracunski_koef_id', $request->month_id)
        ->orderBy('maticni_broj', 'asc')
        ->get();


    $updatedDkopData =  $dkopData->map(function ($dkop){
        $dkop['mdrData']=$this->maticnadatotekaradnikaInterface->getById($dkop->user_mdr_id);
        return $dkop;
    });
    $date = new \DateTime($monthData->datum);
    $datum = $date->format('m.Y');
    $selectOptionData =$this->obradaDkopSveVrstePlacanjaInterface->getAll()
        ->unique('sifra_vrste_placanja')->sortBy('sifra_vrste_placanja')->toArray();


    set_time_limit(0);

    $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
    $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);


//        return view('obracunzarada::izvestaji.datotekaobracunskihkoeficijenata_exportpdf_po_vrsti_placanja',[
//            'month_id'=>$request->month_id,
//            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
//            'dkopData'=>$updatedDkopData,
//            'datum'=>$datum,
//            'podaciFirme'=>$podaciFirme,
//            'podaciMesec'=>$podaciMesec
//        ]);
    $podaciMesec->datum = date('m.Y', strtotime($podaciMesec->datum));
    $pdf = PDF::loadView('obracunzarada::izvestaji.datotekaobracunskihkoeficijenata_exportpdf_po_vrsti_placanja_alimentacija', [
        'month_id'=>$request->month_id,
        'selectOptionData'=>$selectOptionData,
        'sifraVrstePlacanja'=>$sifraVrstePlacanja,
        'dkopData'=>$updatedDkopData,
        'datum'=>$datum,
        'vrsta_placanja'=>$sifraVrstePlacanja,
        'podaciFirme'=>$podaciFirme,
        'podaciMesec'=>$podaciMesec
    ])->setPaper('a4', 'portrait');

    set_time_limit(0);


    return $pdf->download('pdf_' . $sifraVrstePlacanja . '_' . date("d.m.y") . '.pdf');

}


    public function stampaPoVrstiPlacanjaKreditiMaticni(Request $request)
    {}
    public function stampaPoVrstiPlacanjaKreditiKreditori(Request $request)
    {

        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $sifraVrstePlacanja = $request->vrsta_placanja;

        $kreditorId = $request->kreditor_id_export;
        $dkopData = $this->dkopSveVrstePlacanjaInterface->where('sifra_vrste_placanja','093')->where('obracunski_koef_id',$request->month_id)->orderBy('maticni_broj', 'asc')->get();
        $kreditoriData = $this->kreditoriInterface->getAll()->keyBy('sifk_sifra_kreditora')->toArray();
        $updatedDkopData =  $dkopData->map(function ($dkop)use ($kreditoriData){
            if($dkop->kredit_glavna_tabela_id !==null){
                $kredit=$this->dpsmKreditiInterface->getById($dkop->kredit_glavna_tabela_id);
                $kreditor= $kreditoriData[$kredit->SIFK_sifra_kreditora];
                $dkop['mdrData']=$this->maticnadatotekaradnikaInterface->getById($dkop->user_mdr_id);
                $dkop['naziv_kreditora']=$kreditor['sifk_sifra_kreditora'].' - '. $kreditor['imek_naziv_kreditora'];
                $dkop['sifra_kreditora_only']=$kreditor['sifk_sifra_kreditora'];
                $dkop['kreditData']=$kredit;
            }

            return $dkop;
        });
        $kreditorData = [];
        if($kreditorId=='000'){
            $kreditorData=$updatedDkopData->sortBy('naziv_kreditora')->groupBy('naziv_kreditora');
        }else{
            $kreditorData= $updatedDkopData->sortBy('naziv_kreditora')->where('sifra_kreditora_only',$kreditorId)->groupBy('naziv_kreditora');

        }




        $date = new \DateTime($monthData->datum);
        $datum = $date->format('m.Y');
        $selectOptionData =$updatedDkopData->unique('sifra_kreditora_only')->pluck('naziv_kreditora','sifra_kreditora_only')->toArray();

        ksort($selectOptionData);
        set_time_limit(0);

        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);


//        return view('obracunzarada::izvestaji.datotekaobracunskihkoeficijenata_exportpdf_po_vrsti_placanja',[
//            'month_id'=>$request->month_id,
//            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
//            'dkopData'=>$updatedDkopData,
//            'datum'=>$datum,
//            'podaciFirme'=>$podaciFirme,
//            'podaciMesec'=>$podaciMesec
//        ]);
        $podaciMesec->datum = date('m.Y', strtotime($podaciMesec->datum));
        $pdf = PDF::loadView('obracunzarada::izvestaji.datotekaobracunskihkoeficijenata_exportpdf_po_vrsti_placanja_krediti_po_kreditorima', [
            'month_id'=>$request->month_id,
            'selectOptionData'=>$selectOptionData,
            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
            'dkopData'=>$kreditorData,
            'datum'=>$datum,
            'vrsta_placanja'=>$sifraVrstePlacanja,
            'podaciFirme'=>$podaciFirme,
            'podaciMesec'=>$podaciMesec
        ])->setPaper('a4', 'portrait');

        set_time_limit(0);


        return $pdf->download('pdf_' . $sifraVrstePlacanja . '_' . date("d.m.y") . '.pdf');
    }


}
