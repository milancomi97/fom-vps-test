<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\KreditoriRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Service\ExportFajlovaBankeService;
use App\Modules\Obracunzarada\Service\ObradaObracunavanjeService;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;

use ZipArchive;

class IzvestajZaradaController extends Controller
{




    public function __construct(
        private readonly ObradaObracunavanjeService                          $obradaObracunavanjeService,
        private readonly VrsteplacanjaRepositoryInterface                    $vrsteplacanjaInterface,
        private readonly PodaciofirmiRepositoryInterface                     $podaciofirmiInterface,
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface       $obradaDkopSveVrstePlacanjaInterface,
        private readonly ObradaZaraPoRadnikuRepositoryInterface              $obradaZaraPoRadnikuInterface,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly PripremiPermisijePoenteriOdobravanja $pripremiPermisijePoenteriOdobravanja,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface,
        private readonly  MinimalnebrutoosnoviceRepositoryInterface $minimalnebrutoosnoviceInterface,
        private readonly IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface,
        private readonly ObradaKreditiRepositoryInterface $obradaKreditiInterface,
        private readonly KreditoriRepositoryInterface $kreditoriInterface,
        private readonly ExportFajlovaBankeService $exportFajlovaBankeService


    )
    {
    }



    public function ranglistazarade(Request $request)
    {

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

        return view('obracunzarada::izvestaji.ranglista_zarade',
            ['month_id'=>$request->month_id,'groupedZara'=>$groupedZara,'strucneKvalifikacijeSifarnik'=>$strucneKvalifikacijeSifarnik,'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]);
    }


    public function rekapitulacijazarade(Request $request)
    {

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

//        $zaraUkupno = $zaraData =$this->obradaZaraPoRadnikuInterface->getAll();
        $zaraUkupno =$this->obradaZaraPoRadnikuInterface->getAll();

        $date = new DateTime($monthData->datum);
        $datum = $date->format('m.Y');

        $radnikaSaZaradom=$this->obradaZaraPoRadnikuInterface->whereCondition('IZNETO_zbir_ukupni_iznos_naknade_i_naknade','>',0)->get();
        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
        return view('obracunzarada::izvestaji.rekapitulacija_zarade',
            [
                'month_id'=>$request->month_id,
                'dkopData'=>$dkopData,
                'zaraData'=>$zaraData,
                'vrstePlacanjaSifarnik'=>$vrstePlacanjaSifarnik,
                'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik,
                'aktivnihRadnika'=>$zaraUkupno->count(),
                'radnikaSaZaradom'=>$radnikaSaZaradom->count(),
                'datum'=>$datum
            ]);
    }


    public function pripremaBankeRadnik(Request $request)
    {
        $isplatnaMestaSifarnika =$this->isplatnamestaInterface->getAll()->keyBy('rbim_sifra_isplatnog_mesta');
        $test='test';

        $showAll = (int)$request->prikazi_sve;


        if($showAll){
            $resultData = $this->obradaZaraPoRadnikuInterface->with('maticnadatotekaradnika')->get();
//            rbim_sifra_isplatnog_mesta
            $groupedData = $resultData->sortBy('maticni_broj')->groupBy('rbim_sifra_isplatnog_mesta');
        }else{

        if(isset($request->banke_ids)){
            $bankeIds = $request->banke_ids;

            $resultData = $this->obradaZaraPoRadnikuInterface->whereIn('rbim_sifra_isplatnog_mesta',$bankeIds)->with('maticnadatotekaradnika')->get();
           $groupedData = $resultData->sortBy('maticni_broj')->groupBy('rbim_sifra_isplatnog_mesta');

        }

        }
                return view('obracunzarada::izvestaji.banke_banke_radnik',
            [
                'bankeDataZara' =>$groupedData,
                'isplatnaMestaSifarnika'=>$isplatnaMestaSifarnika,
                'pdfInputShowAll'=>$showAll,
                'pdfInputBankeIds'=>$request->banke_ids
            ]);

    }


    public function pripremaBankeRadnikPdfExport(Request $request)
    {
        $isplatnaMestaSifarnika = $this->isplatnamestaInterface->getAll()->keyBy('rbim_sifra_isplatnog_mesta');
        $test = 'test';

        $showAll = (int)$request->prikazi_sve;


        if ($showAll) {
            $resultData = $this->obradaZaraPoRadnikuInterface->with('maticnadatotekaradnika')->get();
//            rbim_sifra_isplatnog_mesta
            $groupedData = $resultData->sortBy('maticni_broj')->groupBy('rbim_sifra_isplatnog_mesta');
        } else {

            if (isset($request->banke_ids)) {
                $bankeIds =json_decode($request->banke_ids,true);

                $resultData = $this->obradaZaraPoRadnikuInterface->whereIn('rbim_sifra_isplatnog_mesta', $bankeIds)->with('maticnadatotekaradnika')->get();
                $groupedData = $resultData->sortBy('maticni_broj')->groupBy('rbim_sifra_isplatnog_mesta');

            }

        }
        set_time_limit(0);
//
//        return view('obracunzarada::izvestaji.banke_banke_radnik_pdf',
//            [
//                'bankeDataZara' => $groupedData,
//                'isplatnaMestaSifarnika' => $isplatnaMestaSifarnika
//            ]);
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $datumStampe = \Carbon\Carbon::now()->format('d.m.Y');

                $pdf = PDF::loadView('obracunzarada::izvestaji.banke_banke_radnik_pdf',
                    [
                        'bankeDataZara' => $groupedData,
                        'isplatnaMestaSifarnika' => $isplatnaMestaSifarnika,
                        'podaciFirme'=>$podaciFirme,
                        'datumStampe'=>$datumStampe
                        ])->setPaper('a4', 'portrait');

        return $pdf->stream('pdf_isplate_po_tc_'.date("d.m.y").'.pdf');

        return $pdf->download('pdf_isplate_po_tc_'.date("d.m.y").'.pdf');

    }



//
//
//
//


    public function pripremaBankeKrediti(Request $request)
    {

        $showAll = (int)$request->prikazi_sve;


        $kreditoriSifarnik = $this->kreditoriInterface->getAll()->keyBy('sifk_sifra_kreditora')->toArray();

        $maticnaDatotekaRadnika = $this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan',true)->get()->keyBy('MBRD_maticni_broj')->toArray();

        if($showAll){
            $resultData = $this->obradaKreditiInterface->getAll();
//            rbim_sifra_isplatnog_mesta
            $groupedData = $resultData->sortBy('maticni_broj')->groupBy('SIFK_sifra_kreditora');

        }else{

            if(isset($request->kreditori_ids)){
                $kreditoriIds = $request->kreditori_ids;

                $resultData = $this->obradaKreditiInterface->whereIn('SIFK_sifra_kreditora',$kreditoriIds)->get();
                // ucitaj mdr
                $groupedData = $resultData->sortBy('maticni_broj')->groupBy('SIFK_sifra_kreditora');


            }

        }
                return view('obracunzarada::izvestaji.banke_kreditori_radnik',
            [
                'kreditiDataZara' =>$groupedData,
                'kreditoriSifarnik'=>$kreditoriSifarnik,
                'mdrSifarnik'=>$maticnaDatotekaRadnika,
                'pdfInputShowAll'=>$showAll,
                'pdfInputKreditoriIds'=>$request->kreditori_ids
            ]);

    }

    public function pripremaBankeKreditiPdfExport(Request $request)
    {

        $showAll = (int)$request->prikazi_sve;


        $kreditoriSifarnik = $this->kreditoriInterface->getAll()->keyBy('sifk_sifra_kreditora')->toArray();

        $maticnaDatotekaRadnika = $this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan',true)->get()->keyBy('MBRD_maticni_broj')->toArray();

        if($showAll){
            $resultData = $this->obradaKreditiInterface->getAll();
//            rbim_sifra_isplatnog_mesta
            $groupedData = $resultData->sortBy('maticni_broj')->groupBy('SIFK_sifra_kreditora');

        }else{

            if(isset($request->kreditori_ids)){
                $kreditoriIds = json_decode($request->kreditori_ids,true);

                $resultData = $this->obradaKreditiInterface->whereIn('SIFK_sifra_kreditora',$kreditoriIds)->get();
                // ucitaj mdr
                $groupedData = $resultData->sortBy('maticni_broj')->groupBy('SIFK_sifra_kreditora');


            }

        }

        set_time_limit(0);
//
//        return view('obracunzarada::izvestaji.banke_banke_radnik_pdf',
//            [
//                'bankeDataZara' => $groupedData,
//                'isplatnaMestaSifarnika' => $isplatnaMestaSifarnika
//            ]);
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $datumStampe = \Carbon\Carbon::now()->format('d.m.Y');



        $pdf = PDF::loadView('obracunzarada::izvestaji.banke_kreditori_radnik_pdf',
            [
                'kreditiDataZara' =>$groupedData,
                'kreditoriSifarnik'=>$kreditoriSifarnik,
                'mdrSifarnik'=>$maticnaDatotekaRadnika,
                'podaciFirme' => $podaciFirme,
                'datumStampe'=>$datumStampe
            ])->setPaper('a4', 'portrait');

        return $pdf->stream('pdf_isplate_krediti_'.date("d.m.y").'.pdf');

        return $pdf->download('pdf_isplate_krediti_'.date("d.m.y").'.pdf');

    }



    public function pripremaBankeFajloviExport(Request $request)
    {
        $isplatnaMestaSifarnika = $this->isplatnamestaInterface->getAll()->keyBy('rbim_sifra_isplatnog_mesta');
        $test = 'test';

        $showAll = (int)$request->prikazi_sve;


        if ($showAll) {
            $resultData = $this->obradaZaraPoRadnikuInterface->with('maticnadatotekaradnika')->get();
//            rbim_sifra_isplatnog_mesta
            $groupedData = $resultData->sortBy('maticni_broj')->groupBy('rbim_sifra_isplatnog_mesta');
        } else {

            if (isset($request->banke_ids)) {
                $bankeIds =json_decode($request->banke_ids,true);

                $resultData = $this->obradaZaraPoRadnikuInterface->whereIn('rbim_sifra_isplatnog_mesta', $bankeIds)->with('maticnadatotekaradnika')->get();
                $groupedData = $resultData->sortBy('maticni_broj')->groupBy('rbim_sifra_isplatnog_mesta');

            }

        }
        set_time_limit(0);
//
//        return view('obracunzarada::izvestaji.banke_banke_radnik_pdf',
//            [
//                'bankeDataZara' => $groupedData,
//                'isplatnaMestaSifarnika' => $isplatnaMestaSifarnika
//            ]);
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $datumStampe = \Carbon\Carbon::now()->format('d.m.Y');
        $downloadRawData =[];
        foreach ($groupedData as $groupKey => $groupItems) {
            if(isset(ExportFajlovaBankeService::BANKEIDS[$groupKey])){

            if(ExportFajlovaBankeService::BANKEIDS[$groupKey]=='RAIFFEISEN'){
                $fileContent = $this->exportFajlovaBankeService->exportRaiffeisen($groupItems,$groupKey,ExportFajlovaBankeService::BANKEIDS[$groupKey]);
                $downloadRawData[]=$fileContent;

            }

            if(ExportFajlovaBankeService::BANKEIDS[$groupKey]=='DIREKTNAEURO') {
                $fileContent = $this->exportFajlovaBankeService->exportDirektnaEuro($groupItems,$groupKey,ExportFajlovaBankeService::BANKEIDS[$groupKey]);
                $downloadRawData[]=$fileContent;

            }

            if(ExportFajlovaBankeService::BANKEIDS[$groupKey]=='INTESA') {
                $fileContent = $this->exportFajlovaBankeService->exportIntesa($groupItems,$groupKey,ExportFajlovaBankeService::BANKEIDS[$groupKey]);
                $downloadRawData[]=$fileContent;

            }

            if(ExportFajlovaBankeService::BANKEIDS[$groupKey]=='OTP') {
                $fileContent = $this->exportFajlovaBankeService->exportOtp($groupItems,$groupKey,ExportFajlovaBankeService::BANKEIDS[$groupKey]);
                $downloadRawData[]=$fileContent;

            }


            if(ExportFajlovaBankeService::BANKEIDS[$groupKey]=='POSTANSKASTEDIONICA') {
                $fileContent = $this->exportFajlovaBankeService->exportPostanskaStedionica($groupItems,$groupKey,ExportFajlovaBankeService::BANKEIDS[$groupKey]);
                $downloadRawData[]=$fileContent;

            }
            if(ExportFajlovaBankeService::BANKEIDS[$groupKey]=='UNICREDIT') {
                $fileContent = $this->exportFajlovaBankeService->exportUnicredit($groupItems,$groupKey,ExportFajlovaBankeService::BANKEIDS[$groupKey]);
                $downloadRawData[]=$fileContent;

            }


            if(ExportFajlovaBankeService::BANKEIDS[$groupKey]=='KOMERCIJALNA') {
                $fileContent = $this->exportFajlovaBankeService->exportKomercijalna($groupItems,$groupKey,ExportFajlovaBankeService::BANKEIDS[$groupKey]);
                $downloadRawData[]=$fileContent;

            }
            }
        }


//        $txtContent = '';

        if(count($downloadRawData)==1){
            $fileName = $downloadRawData[0]['fileName'].'_platni_spisak_' . now()->format('Ymd_His') . '.txt';
            $txtContent= $downloadRawData[0]['data'];
            return response()->streamDownload(function () use ($txtContent) {
                echo $txtContent;
            }, $fileName);
        }
        if(count($downloadRawData)>1){
            $zip = new ZipArchive;
            $zipFileName = 'izvestaji_' . now()->format('Ymd_His') . '.zip';
            $zipPath = storage_path("app/{$zipFileName}");
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                foreach ($downloadRawData as $key=>$data) {
                    if ($data['data'] !== '') {
                        $fileName = $data['fileName'].'_platni_spisak_' . now()->format('Ymd_His') . '.txt';
                        $zip->addFromString($fileName, $data['data']);
                    }


                }
                $zip->close();
            }
            return response()->download($zipPath)->deleteFileAfterSend(true);

        }


    }

}
