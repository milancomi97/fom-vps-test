<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Exports\PoenterUnosExport;
use App\Http\Controllers\Controller;
use App\Mail\DemoMail;
use App\Models\UserPermission;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
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


class DatotekaobracunskihEmailController extends Controller
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
        $pdf = PDF::loadView('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
            [
                'rows'=>$rows,
                'data'=>$troskovniCentarCalculated,
                'tableHeaders'=>$tableHeaders,
                'vrstePlacanjaDescription'=>$vrstePlacanjaDescription,
                'organizacioneCelineSifarnik'=>$organizacioneCelineSifarnik
            ]
        )->setPaper('a4', 'portrait');

        return $pdf->download('pdf_poenteri_'.date("d.m.y").'.pdf');

    }

    public function emailRadnikLista(Request $request){


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
        if($request->email_to !==null) {
            $mailData = [
                'title' => 'Naslov',
                'body' => 'Sadrzaj',
                'subject' => 'Obračunski list: ' . $radnikMaticniId,
                'pdf' => $pdf->output(),
                'filenamepdf'=>'obracunska_lista_'.$radnikMaticniId.'_'.date("d.m.y")
            ];


            Mail::to($request->email_to)->send(new DemoMail($mailData));
        }
//
//        return $pdf->output();
        return redirect()->back();


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

    public function emailRadnikListaAll(Request $request){


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



        $zarRadnici = $this->obradaZaraPoRadnikuInterface->getAll();

        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();
        $date = new \DateTime($podaciMesec->datum);
        $formattedDate = $date->format('m.Y');
        $datumStampe = Carbon::now()->format('d. m. Y.');
        foreach ($zarRadnici as $radnik) {
            $test = 'test';
            $radnikEmail=$radnik->maticnadatotekaradnika->email_za_plate;


            $radnikEmailStatus = $radnik->maticnadatotekaradnika->email_za_plate_poslat;

            if($radnikEmail!==null){
                $radnikMaticniId=$radnik->maticni_broj;
                $radnikData = $this->obradaObracunavanjeService->pripremaPodatakaRadnik($monthId,$radnikMaticniId);
                $mdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$radnikMaticniId)->get()->first();

                $mdrDataCollection = collect($mdrData);
                $mdrPreparedData = $this->obradaObracunavanjeService->pripremaMdrPodatakaRadnik($mdrDataCollection);

                $troskovnoMesto = $this->organizacionecelineInterface->getById($mdrDataCollection['troskovno_mesto_id']);


                $dkopData = $this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get();


                $zarData = $this->obradaZaraPoRadnikuInterface->where('maticni_broj', $mdrData->MBRD_maticni_broj)->get()->first();
                $kreditiData = $this->obradaKreditiInterface->where('maticni_broj', $mdrData->MBRD_maticni_broj)->get();
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


                $mailData = [
                    'title' => 'Naslov',
                    'body' => 'Sadrzaj',
                    'subject' => 'Obračunski list: ' . $radnikMaticniId,
                    'pdf' => $pdf->output(),
                    'filenamepdf'=>'obracunska_lista_'.$radnikMaticniId.'_'.date("d.m.y")
                ];








                try {
//                    Mail::to($radnikEmail)->send(new DemoMail($mailData));
                    $sttatus= Mail::to('dimitrijevicm1997@gmail.com')->send(new DemoMail($mailData));

                } catch (\Exception $e) {
                    $test='3';
                }






               $test='test';

            }
        }








//
//        return $pdf->output();
        return redirect()->back();


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


    public function emailRangListe(Request $request){

        $obracunskiKoeficijentId = $request->month_id;

        $dkopData =$this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id',$obracunskiKoeficijentId)->get();
        $zaraData =  $this->obradaZaraPoRadnikuInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id',$obracunskiKoeficijentId)->get();

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
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($obracunskiKoeficijentId);

        $podaciMesec->datum=date('m.Y', strtotime($podaciMesec->datum));
        set_time_limit(0);
        $pdf = PDF::loadView('obracunzarada::izvestaji.ranglista_zarade_export_pdf',
            [
                'podaciFirme'=>$podaciFirme,
                'podaciMesec'=>$podaciMesec,
                'groupedZara'=>$groupedZara,
                'strucneKvalifikacijeSifarnik'=>$strucneKvalifikacijeSifarnik,
                'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]
        )->setPaper('a4', 'portrait');

        if($request->email_to !==null) {
            $pdfOutput=$pdf->output();
            $mailData = [
                'title' => 'Naslov',
                'body' => 'Sadrzaj',
                'subject' => '10 Rang lista: '.date("d.m.y"),
                'pdf' => $pdfOutput,
                'filenamepdf'=>'rang_lista_'.date("d.m.y")
            ];


//            for($i=0;$i < 50; $i++){
                Mail::to($request->email_to)->send(new DemoMail($mailData));

//            }
//                Mail::to($request->email_to)->send(new DemoMail($mailData));
                $test='';

//            Mail::to($request->email_to)->send(new DemoMail($mailData));
        }
//
//        return $pdf->output();
        return redirect()->back();

    }

    public function emailOstvareneZarade(Request $request){
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
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $datumStampe = Carbon::now()->format('d. m. Y.');
        $date = new \DateTime($monthData->datum);
        $datum = $date->format('m.Y');
        $zaraUkupno =$this->obradaZaraPoRadnikuInterface->getAll();
        $radnikaSaZaradom=$this->obradaZaraPoRadnikuInterface->whereCondition('IZNETO_zbir_ukupni_iznos_naknade_i_naknade','>',0)->get();

        set_time_limit(0);
        $pdf = PDF::loadView('obracunzarada::izvestaji.rekapitulacija_zarade_export_pdf',
            ['dkopData'=>$dkopData,
                'podaciFirme'=>$podaciFirme,
                'zaraData'=>$zaraData,
                'datum'=>$datum,
                'aktivnihRadnika'=>$zaraUkupno->count(),
                'radnikaSaZaradom'=>$radnikaSaZaradom->count(),
                'datumStampe'=>$datumStampe,
                'vrstePlacanjaSifarnik'=>$vrstePlacanjaSifarnik,'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik])->setPaper('a4', 'portrait');


        if($request->email_to !==null) {
            $mailData = [
                'title' => 'Naslov',
                'body' => 'Sadrzaj',
                'subject' => 'Ostvarene zarade: '.date("d.m.y"),
                'pdf' => $pdf->output(),
                'filenamepdf'=>'ostvarene_zarade_'.date("d.m.y")
            ];


            Mail::to($request->email_to)->send(new DemoMail($mailData));
        }
//
//        return $pdf->output();
        return redirect()->back();
    }
}
