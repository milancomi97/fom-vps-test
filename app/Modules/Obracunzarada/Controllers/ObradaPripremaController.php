<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ObradaPlate;
use App\Models\Datotekaobracunskihkoeficijenata;
use App\Models\ObradaDkopSveVrstePlacanja;
use App\Models\ObradaKrediti;
use App\Models\ObradaZaraPoRadniku;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Consts\UserRoles;
use App\Modules\Obracunzarada\Repository\ArhivaSumeZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\KreditoriRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PorezdoprinosiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Service\ArhiviranjeMesecaService;
use App\Modules\Obracunzarada\Service\ObradaPripremaService;
use App\Modules\Obracunzarada\Service\ObradaPripremaValidacijaService;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ObradaPripremaController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly UpdateVrstePlacanjaJson                             $updateVrstePlacanjaJson,
        private readonly VrsteplacanjaRepository                             $vrsteplacanjaInterface,
        private readonly DpsmPoentazaslogRepositoryInterface                 $dpsmPoentazaslogInterface,
        private readonly DpsmFiksnaPlacanjaRepositoryInterface               $dpsmFiksnaPlacanjaInterface,
        private readonly ObradaPripremaService                               $obradaPripremaService,
        private readonly ObradaPripremaValidacijaService                     $obradaPripremaValidacijaService,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface       $dkopSveVrstePlacanjaInterface,
        private readonly PorezdoprinosiRepositoryInterface                   $porezdoprinosiInterface,
        private readonly MinimalnebrutoosnoviceRepositoryInterface           $minimalnebrutoosnoviceInterface,
        private readonly ObradaZaraPoRadnikuRepositoryInterface              $obradaZaraPoRadnikuInterface,
        private readonly ArhiviranjeMesecaService                            $arhiviranjeMesecaService,
        private readonly PermesecnatabelapoentRepositoryInterface            $permesecnatabelapoentInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface           $maticnadatotekaradnikaInterface,
        private readonly DpsmKreditiRepositoryInterface                      $dpsmKreditiInterface,
        private readonly ObradaKreditiRepositoryInterface                    $obradaKreditiInterface,
        private readonly ArhivaSumeZaraPoRadnikuRepositoryInterface          $arhivaSumeZaraPoRadnikuInterface,
        private readonly RadniciRepositoryInterface $radniciRepositoryInterface,
        private readonly IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly KreditoriRepositoryInterface $kreditoriInterface



    )
    {
    }


    public function obradaIndex(Request $request)
    {


        if ($request->redirect_url == 'obrada_plate') {

//            ObradaPlate::dispatch();
            $user_id = auth()->user()->id;
            $userPermission = UserPermission::where('user_id', $user_id)->first();
            $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
            $id = $request->month_id;

//            $this->dkopSveVrstePlacanjaInterface->where('obracunski_koef_id', '>', 0)->delete();
//            $this->obradaKreditiInterface->where('obracunski_koef_id', '>', 0)->delete();
//            $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id', '>', 0)->delete();
//            DB::delete('DELETE FROM obrada_dkop_sve_vrste_placanjas WHERE obracunski_koef_id > ?', [1]);
//            DB::delete('DELETE FROM obrada_zara_po_radnikus WHERE obracunski_koef_id > ?', [1]);
//            DB::delete('DELETE FROM obrada_kreditis WHERE obracunski_koef_id > ?', [1]);

            ObradaDkopSveVrstePlacanja::truncate();
            ObradaZaraPoRadniku::truncate();
            ObradaKrediti::truncate();
//            DB::statement('ALTER TABLE obrada_dkop_sve_vrste_placanjas AUTO_INCREMENT = 1');
//            DB::statement('ALTER TABLE obrada_zara_po_radnikus AUTO_INCREMENT = 1');
//            DB::statement('ALTER TABLE obrada_kreditis AUTO_INCREMENT = 1');


//        $poenteriData = $this->mesecnatabelapoentazaInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id',$id)->select('vrste_placanja','user_id','maticni_broj','obracunski_koef_id')->get();
            $poenteriData = $this->mesecnatabelapoentazaInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id', $id)->get();

            // $prviPodatakListaPlacanjaKojaSeObradjuje
            $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
            $poresDoprinosiSifarnik = $this->porezdoprinosiInterface->getAll()->first();

            $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
            $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($monthData->datum);
            $poenteriPrepared = $this->obradaPripremaService->pripremiUnosPoentera($poenteriData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);
//


            $allFiksnaPlacanjaData = $this->dpsmFiksnaPlacanjaInterface->with('maticnadatotekaradnika')->get();
            if ($allFiksnaPlacanjaData->count()) {
                $allFiksnaPlacanjaPrepared = $this->obradaPripremaService->pripremiFiksnaPlacanja($allFiksnaPlacanjaData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik);
                $status = $this->dkopSveVrstePlacanjaInterface->createMany($allFiksnaPlacanjaPrepared);
            }


//            $akontacijeData = $this->dpsmAkontacijeInterface->where('obracunski_koef_id',$id)->get();
//            $akontacijePrepared = $this->obradaPripremaService->pripremiAkontacije($akontacijeData);
//
            $varijabilnaData = $this->dpsmPoentazaslogInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id', $id)->get();
            if ($varijabilnaData->count()) {
                $varijabilnaPrepared = $this->obradaPripremaService->pripremiVarijabilnihPlacanja($varijabilnaData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik);
                $status = $this->dkopSveVrstePlacanjaInterface->createMany($varijabilnaPrepared);

            }

            $status = $this->dkopSveVrstePlacanjaInterface->createMany($poenteriPrepared);


            $minuliRadData = $this->obradaPripremaService->pripremiMinuliRad($poenteriData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik);

            $status = $this->dkopSveVrstePlacanjaInterface->createMany($minuliRadData);

            $sveVrstePlacanjaData = $this->dkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $id)->get();
            //
//
//            $sveVrstePlacanjaDataFormule = $this->obradaFormuleService->obradiFormule($sveVrstePlacanjaData); // G i EVAL odradi


//        $kreditiData = $this->dpsmKreditiInterface->getAll();
//        $kreditiPrepared =  $this->obradaPripremaService->pripremaKredita($kreditiData,$id,$vrstePlacanjaSifarnik);
//        $this->obradaKreditiInterface->createMany($kreditiPrepared);


            $message = $this->obradaPripremaValidacijaService->checkMinimalneBrutoOsnovice($minimalneBrutoOsnoviceSifarnik);

            if ($message) {
                return response()->json(['status' => false, 'message' => 'Greska u obradi: ' . $message]);
            }
//            0006227
            try {
                $sveVrstePlacanjaDataSummarize = $this->obradaPripremaService->pripremaZaraPodatkePoRadnikuBezMinulogRada($sveVrstePlacanjaData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);
            } catch (\Throwable $exception) {
                report($exception);
                $newMessage = "Greska u obradi:";
                return response()->json(['status' => false, 'message' => 'Greska u obradi: ' . $exception->getMessage(),'razlog'=>$exception->getTraceAsString()]);

            }
        }
        $redirectUrl = $this->resolveRedirectUrl($request->redirect_url, $request->month_id);

        return response()->json(['id' => $request->month_id, 'status' => true, 'redirectUrl' => $redirectUrl]);

    }


    public function show(Request $request)
    {

        $user_id = auth()->user()->id;
        $userPermission = UserPermission::where('user_id', $user_id)->first();
        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
        $id = $request->radnik_id;
        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($id);
        $month_id = $mesecnaTabelaPoentaza->obracunski_koef_id;
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($month_id);


        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');
        $vrstePlacanja = $this->vrsteplacanjaInterface->where('DOVP_tip_vrste_placanja', true)->get();

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show',
            [
                'monthData' => $formattedDate,
                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'vrstePlacanja' => $vrstePlacanja->toJson(),
                'vrstePlacanjaData' => $mesecnaTabelaPoentaza->vrste_placanja
            ]);
    }


    public function updateAll(Request $request)
    {
        // Logika za varijabilne vrste placanja
        $vrstePlacanjaData = $request->vrste_placanja;
        $record_id = $request->record_id;
        $radnikEvidencija = $this->mesecnatabelapoentazaInterface->getById($record_id);
        $status = $this->updateVrstePlacanjaJson->updateAll($radnikEvidencija, $vrstePlacanjaData);

        if ($status) {
            $message = 'uspesno promenjen';
            return response()->json(['message' => $message, 'status' => true], 200);

        }
        $message = 'greska';
        return response()->json(['message' => $message, 'status' => false], 200);
    }

    public function resolveRedirectUrl($url, $monthId)
    {

        if ($url == 'obrada_plate') {

            return url('obracunzarada/datotekaobracunskihkoeficijenata/create');

        }
        if ($url == 'obracunski_listovi') {
            return url('obracunzarada/datotekaobracunskihkoeficijenata/show_all_plate?month_id=') . $monthId;
        } elseif ($url == 'rang_lista_zarada') {
            return url('obracunzarada/izvestaji/ranglistazarade?month_id=') . $monthId;

        } elseif ($url == 'rekapitulacija_zarada') {
            return url('obracunzarada/izvestaji/rekapitulacijazarade?month_id=') . $monthId;
        }


    }


    public function arhiviranjeMeseca(Request $request)
    {

        $monthId = $request->month_id;

        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);


        $datum = Carbon::createFromFormat('Y-m-d', $monthData->datum);

        // TODO 2. ARCHIVE
        $mdrData = $this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan', 1)->get();
        $mdrDataResult = $this->arhiviranjeMesecaService->archiveMDR($mdrData, $datum);


        $dkopData = $this->dkopSveVrstePlacanjaInterface->getAll();
        $dkopDataResult = $this->arhiviranjeMesecaService->archiveDkop($dkopData, $datum);

        $zaraData = $this->obradaZaraPoRadnikuInterface->getAll();
        $zaraDataResult = $this->arhiviranjeMesecaService->archiveZara($zaraData, $datum);


        $varijabilna = $this->dpsmPoentazaslogInterface->getAll();
        $poenterData = $this->mesecnatabelapoentazaInterface->getAll();
        $pristupi = $this->permesecnatabelapoentInterface->where('status',1)->get();

        // glavnaKrediti
        $dpsmKrediti = $this->dpsmKreditiInterface->getAll();
        // POMOCNA KREDITI
        $kreditiPomocni = $this->obradaKreditiInterface->getAll();


        $zaraDataResult = $this->arhiviranjeMesecaService->resolveKrediti($dpsmKrediti, $kreditiPomocni);


        $this->dkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $monthId)->delete();
        $this->obradaKreditiInterface->where('obracunski_koef_id', $monthId)->delete();

        $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id', $monthId)->delete();


//        $pristupi->each->delete();
        $kreditiPomocni->each->delete();
        $varijabilna->each->delete();
        $poenterData->each->delete();
        $monthData->status = Datotekaobracunskihkoeficijenata::ARHIVIRAN;
        $monthData->save();


        return response()->json(['status' => true]);

    }


    public function obradaProseka(Request $request)
    {
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $datum = Carbon::createFromFormat('Y-m-d', $monthData->datum)->startOfMonth();
        $endDate = $datum->format('m.Y');


        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_obrada_proseka',[
            'endDate'=>$endDate,
            'monthId'=>$request->month_id
        ]);
    }

    public function obradaProsekaPrikaz(Request $request)
    {
        // SKINI 1 mesec

        $periodOd = $request->arhiva_datum_od;
        $periodDo=$request->arhiva_datum;
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);

        $startPeriod = \Illuminate\Support\Carbon::createFromFormat('m.Y', $periodOd)->startOfMonth();
        $endPeriod = \Illuminate\Support\Carbon::createFromFormat('m.Y', $periodDo)->startOfMonth();

        $startDate = $startPeriod->format('Y-m-d');
        $endDate = $endPeriod->format('Y-m-d');



        $zaraSummarize = $this->arhivaSumeZaraPoRadnikuInterface
            ->between('M_G_date', $startPeriod, $endPeriod)
            ->get();


        $zaraResult =$zaraSummarize->groupBy('maticni_broj');

        $test='test';

        $sumResult=[];

        foreach ($zaraResult as $datum => $radnikData){

            foreach ($radnikData as $mesecData){
                $maticniBroj = $mesecData['maticni_broj'];

                    if(in_array($maticniBroj,array_keys($sumResult))){

                        $sumResult[$maticniBroj]=[
                            'PRIZ_prosecni_iznos_godina'=>$mesecData['PRIZ_prosecni_iznos_godina']+$sumResult[$maticniBroj]['PRIZ_prosecni_iznos_godina'],
                            'PRCAS_prosecni_sati_godina'=> $mesecData['PRCAS_prosecni_sati_godina']+$sumResult[$maticniBroj]['PRCAS_prosecni_sati_godina'],
                            'broj_meseci'=>$sumResult[$maticniBroj]['broj_meseci']+1
                        ];
                    }else{
                        $sumResult[$maticniBroj]=[
                            'PRIZ_prosecni_iznos_godina'=>$mesecData['PRIZ_prosecni_iznos_godina'],
                            'PRCAS_prosecni_sati_godina'=> $mesecData['PRCAS_prosecni_sati_godina'],
                            'broj_meseci'=>1
                        ];
                    }

                }

            $Test='sledeciMesec';

        }
        $test='test';


        $currentMonthDate = Carbon::parse($monthData->datum);
        $currentMonthDateFormatted = $currentMonthDate->format('m.Y');


        if($currentMonthDateFormatted ==$periodDo){
            foreach ($sumResult as $maticniBroj =>$radnik){
                $activeZara = $this->obradaZaraPoRadnikuInterface->where('maticni_broj',$maticniBroj)->first();
                if($activeZara){
                    $radnik['PRIZ_prosecni_iznos_godina']+=$activeZara->PRIZ_prosecni_iznos_godina;
                    $radnik['PRCAS_prosecni_sati_godina']+=$activeZara->PRCAS_prosecni_sati_godina;
                    $radnik['broj_meseci']+=1;
                }

            }
        }

        foreach ($sumResult as $maticniBroj => $radnik){
           $mdr= $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$maticniBroj)->where('ACTIVE_aktivan',1)->first();

            if($mdr!==null){
                $mdr->PRIZ_ukupan_bruto_iznos =$radnik['PRIZ_prosecni_iznos_godina'];
                $mdr->PRCAS_ukupni_sati_za_ukupan_bruto_iznost=$radnik['PRCAS_prosecni_sati_godina'];
                $mdr->BROJ_broj_meseci_za_obracun=$radnik['broj_meseci'];
                $mdr->save();
            }
        }

        $updatedMdr = $this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan',1)->orderBy('MBRD_maticni_broj')->get();


        $userData = Auth::user()->load(['permission']);
        $permissions = $userData->permission;

//        @if(auth()->user()->userPermission->role_id==UserRoles::SUPERVIZOR)

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_obrada_proseka_prikaz',['sumResult'=>$updatedMdr,'userPermission'=>$permissions]);
    }


    public function prikazPoVrstiPlacanja(Request $request){
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $sifraVrstePlacanja = $request->vrsta_placanja;
        $dkopData = $this->dkopSveVrstePlacanjaInterface->where('sifra_vrste_placanja',$sifraVrstePlacanja)->where('obracunski_koef_id',$request->month_id)->orderBy('maticni_broj', 'asc')->get();
        $user_id = auth()->user()->id;

        $userPermission = UserPermission::where('user_id', $user_id)->first();


        $updatedDkopData =  $dkopData->map(function ($dkop){
            $dkop['mdrData']=$this->maticnadatotekaradnikaInterface->getById($dkop->user_mdr_id);
            return $dkop;
        });
        $date = new \DateTime($monthData->datum);
        $datum = $date->format('m.Y');
        $selectOptionData =$this->dkopSveVrstePlacanjaInterface->getAll()->unique('sifra_vrste_placanja')->sortBy('sifra_vrste_placanja')->toArray();


        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_prikaz_po_vrsti_placanja',[
            'month_id'=>$request->month_id,
            'selectOptionData'=>$selectOptionData,
            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
            'dkopData'=>$updatedDkopData,
            'datum'=>$datum,
            'vrsta_placanja'=>$sifraVrstePlacanja,
            'userPermission'=>$userPermission
        ]);
    }

    public function formaPoVrstiPlacanja(Request $request)
    {

        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);

        $selectOptionData =$this->dkopSveVrstePlacanjaInterface->getAll()->unique('sifra_vrste_placanja')->sortBy('sifra_vrste_placanja')->toArray();

        //        ksort($selectOptionData);
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_form_po_vrsti_placanja',[
            'selectOptionData'=>$selectOptionData,
            'month_id'=>$request->month_id
        ]);

        $test='test';
    }

    public function prikazAlimentacija(Request $request){
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $sifraVrstePlacanja = $request->vrsta_placanja;
        $dkopData = $this->dkopSveVrstePlacanjaInterface
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
        $selectOptionData =$this->dkopSveVrstePlacanjaInterface->getAll()
            ->unique('sifra_vrste_placanja')->sortBy('sifra_vrste_placanja')->toArray();


        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_prikaz_alimentacija',[
            'month_id'=>$request->month_id,
            'selectOptionData'=>$selectOptionData,
            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
            'dkopData'=>$updatedDkopData,
            'datum'=>$datum,
            'vrsta_placanja'=>$sifraVrstePlacanja
        ]);
    }
    public function prikazKredita(Request $request){
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $sifraVrstePlacanja = $request->vrsta_placanja;
        $dkopData = $this->dkopSveVrstePlacanjaInterface->where('sifra_vrste_placanja',$sifraVrstePlacanja)->where('obracunski_koef_id',$request->month_id)->orderBy('maticni_broj', 'asc')->get();


        $kreditoriData = $this->kreditoriInterface->getAll()->keyBy('sifk_sifra_kreditora')->toArray();

        $updatedDkopData =  $dkopData->map(function ($dkop)use ($kreditoriData){

            if($dkop->kredit_glavna_tabela_id !==null){
                $kredit=$this->dpsmKreditiInterface->getById($dkop->kredit_glavna_tabela_id);
                $kreditor= $kreditoriData[$kredit->SIFK_sifra_kreditora];
                $dkop['mdrData']=$this->maticnadatotekaradnikaInterface->getById($dkop->user_mdr_id);
                $dkop['naziv_kreditora']=$kreditor['sifk_sifra_kreditora'].' - '. $kreditor['imek_naziv_kreditora'];
                $dkop['kreditData']=$kredit;

            }

            return $dkop;
        });


        $date = new \DateTime($periodDo);
        $datum = $date->format('m.Y');
        $selectOptionData =$this->dkopSveVrstePlacanjaInterface->getAll()->unique('sifra_vrste_placanja')->toArray();


//        $kreditoriSelectOption = array_map(function($kreditor) use ($kreditoriData) {
//
//            $test='test';
//            return [
//                'id' => $kreditoriData[$kreditor]['sifk_sifra_kreditora'],
//                'text' =>$kreditoriData[$kreditor]['sifk_sifra_kreditora'].' - '. $kreditoriData[$kreditor]['imek_naziv_kreditora']
//            ];
//        }, $kreditoriKrediti);
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_prikaz_kredita',[
            'month_id'=>$request->month_id,
            'selectOptionData'=>$selectOptionData,
            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
            'dkopData'=>$updatedDkopData,
            'datum'=>$datum,
            'vrsta_placanja'=>$sifraVrstePlacanja
        ]);
    }

    public function prikazKreditaPoKreditoru(Request $request){
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
        $sifraVrstePlacanja = $request->vrsta_placanja;

        $kreditorId = $request->kreditor_id;
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

//        $kreditoriSelectOption = array_map(function($kreditor) use ($kreditoriData) {
//
//            $test='test';
//            return [
//                'id' => $kreditoriData[$kreditor]['sifk_sifra_kreditora'],
//                'text' =>$kreditoriData[$kreditor]['sifk_sifra_kreditora'].' - '. $kreditoriData[$kreditor]['imek_naziv_kreditora']
//            ];
//        }, $kreditoriKrediti);
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_prikaz_kredita_po_kreditorima',[
            'month_id'=>$request->month_id,
            'selectOptionData'=>$selectOptionData,
            'sifraVrstePlacanja'=>$sifraVrstePlacanja,
            'dkopData'=>$kreditorData,
            'datum'=>$datum,
            'vrsta_placanja'=>$sifraVrstePlacanja,
            'selectedKreditorId'=>$kreditorId
        ]);
    }
    public function podesavanjePristupa(Request $request){

       $organizacioneCelineData = $this->permesecnatabelapoentInterface->where('obracunski_koef_id',$request->month_id)->get();
        $radniciCollection = $this->radniciRepositoryInterface->where('active',1)->get()->keyBy('id');

        $dataFullData = $organizacioneCelineData->map(function ($item, $key) {
            $item['odgovorna_lica_ids']=json_decode($item['odgovorna_lica_ids'],true);
            $item['poenteri_ids']=json_decode($item['poenteri_ids'],true);

            return $item;
        });


        $selectPoenteri = UserPermission::where('role_id',UserRoles::POENTER)->orWhere('role_id', UserRoles::ADMINISTRATOR)->get()->pluck('user_id','user_id');

        $selectOdgovornaLica = UserPermission::where('role_id',UserRoles::ADMINISTRATOR)->orWhere('role_id',UserRoles::SUPERVIZOR)->get()->pluck('user_id','user_id');


        $userIds = array_merge($selectPoenteri->toArray(), $selectOdgovornaLica->toArray());
        $maticnaSifarnik =$this->radniciRepositoryInterface->whereIn('id',$userIds)->get()->keyBy('id');
        $test='test';
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_podesavanje_pristupa', [
            'data' => $dataFullData,
            'radniciFullData'=>$radniciCollection,
            'selectPoenteri'=>$selectPoenteri,
            'selectOdgovornaLica'=>$selectOdgovornaLica,
            'maticnaSifarnik'=>$maticnaSifarnik
            ]);

    }

    public function brisanjePristupa(Request $request){

        $month_id = $request->month_id;
        $user_id=   $request->user_id;
        $org_celina_id= $request->org_celina_id;
        $type = $request->type;
        $organizacioneCelineData = $this->permesecnatabelapoentInterface->where('obracunski_koef_id',$month_id)->get()->keyBy('organizaciona_celina_id');


        if($type=='poenter_delete'){

            $poenterJsonData = json_decode($organizacioneCelineData[$org_celina_id]->poenteri_ids, true);

            if (($key = array_search($user_id, $poenterJsonData)) !== false) {
                unset($poenterJsonData[$key]);

                // Re-index the array
                $poenterJsonData = array_values($poenterJsonData);

                // Encode back to JSON
                $organizacioneCelineData[$org_celina_id]->poenteri_ids = json_encode($poenterJsonData);
                $organizacioneCelineData[$org_celina_id]->save();
                }

            $poenterStatusjsonData = json_decode($organizacioneCelineData[$org_celina_id]->poenteri_status, true);

            if (isset($poenterStatusjsonData[$user_id])) {
                unset($poenterStatusjsonData[$user_id]);

                // Encode back to JSON
                $organizacioneCelineData[$org_celina_id]->poenteri_status = json_encode($poenterStatusjsonData);
                $organizacioneCelineData[$org_celina_id]->save();
            }



        }
        if($type=='odg_lice_delete'){


            $odgLiceJsonData = json_decode($organizacioneCelineData[$org_celina_id]->odgovorna_lica_ids, true);

            if (($key = array_search($user_id, $odgLiceJsonData)) !== false) {
                unset($odgLiceJsonData[$key]);

                // Re-index the array
                $odgLiceJsonData = array_values($odgLiceJsonData);

                // Encode back to JSON
                $organizacioneCelineData[$org_celina_id]->odgovorna_lica_ids = json_encode($odgLiceJsonData);
                $organizacioneCelineData[$org_celina_id]->save();
            }

            $odgLiceStatusjsonData = json_decode($organizacioneCelineData[$org_celina_id]->odgovorna_lica_status, true);

            if (isset($odgLiceStatusjsonData[$user_id])) {
                unset($odgLiceStatusjsonData[$user_id]);

                // Encode back to JSON
                $organizacioneCelineData[$org_celina_id]->odgovorna_lica_status = json_encode($odgLiceStatusjsonData);
                $organizacioneCelineData[$org_celina_id]->save();
            }

        }

    }
    public function izmenaPristupa(Request $request){


        $month_id = $request->month_id;
        $user_id=$request->user_id;
        $org_celina_id= $request->org_celina_id;
        $type = $request->type;
        $organizacioneCelineData = $this->permesecnatabelapoentInterface->where('status',1)->get()->keyBy('organizaciona_celina_id');


        if($type=='poenter_dodaj'){
            $poenterJsonData = json_decode($organizacioneCelineData[$org_celina_id]->poenteri_ids, true);
            $poenterStatusjsonData = json_decode($organizacioneCelineData[$org_celina_id]->poenteri_status, true);

            $poenterJsonData[]=(int)$user_id;


            $poenterStatusjsonData[$user_id]=0;

            $organizacioneCelineData[$org_celina_id]->poenteri_ids = json_encode($poenterJsonData);
            $organizacioneCelineData[$org_celina_id]->poenteri_status = json_encode($poenterStatusjsonData);
            $organizacioneCelineData[$org_celina_id]->save();


        }



        if($type=='odg_lice_dodaj'){


            $test='test';

            $odgLicaJsonData = json_decode($organizacioneCelineData[$org_celina_id]->odgovorna_lica_ids, true);
            $odgLicaStatusjsonData = json_decode($organizacioneCelineData[$org_celina_id]->odgovorna_lica_status, true);

            $odgLicaJsonData[]=$user_id;
            $odgLicaStatusjsonData[$user_id]=0;

            $organizacioneCelineData[$org_celina_id]->odgovorna_lica_ids = json_encode($odgLicaJsonData);
            $organizacioneCelineData[$org_celina_id]->odgovorna_lica_status = json_encode($odgLicaStatusjsonData);
            $organizacioneCelineData[$org_celina_id]->save();

        }


    }
    public function pripremaBanke(Request $request)
    {

        $isplatnaMestaData =$this->isplatnamestaInterface->getAll()->keyBy('rbim_sifra_isplatnog_mesta')->toArray();
       $isplatnaMestaZara = array_keys($this->obradaZaraPoRadnikuInterface->getAll()->groupBy('rbim_sifra_isplatnog_mesta')->toArray());
        $isplatnaMestaSelectOption = array_map(function($isplatnoMestoId) use ($isplatnaMestaData) {
            return [
                'id' => $isplatnaMestaData[$isplatnoMestoId]['rbim_sifra_isplatnog_mesta'],
                'text' =>$isplatnaMestaData[$isplatnoMestoId]['rbim_sifra_isplatnog_mesta'].' - '. $isplatnaMestaData[$isplatnoMestoId]['naim_naziv_isplatnog_mesta']
            ];
        }, $isplatnaMestaZara);

        $kreditoriData = $this->kreditoriInterface->getAll()->keyBy('sifk_sifra_kreditora')->toArray();


        $kreditoriKrediti = array_keys($this->obradaKreditiInterface->getAll()->groupBy('SIFK_sifra_kreditora')->toArray());


        $kreditoriSelectOption = array_map(function($kreditor) use ($kreditoriData) {

            $test='test';
            return [
                'id' => $kreditoriData[$kreditor]['sifk_sifra_kreditora'],
                'text' =>$kreditoriData[$kreditor]['sifk_sifra_kreditora'].' - '. $kreditoriData[$kreditor]['imek_naziv_kreditora']
            ];
        }, $kreditoriKrediti);

        $test='test';
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_priprema_banke', [
            'bankeData'=>$isplatnaMestaSelectOption,
            'kreditoriData'=>$kreditoriSelectOption,
//            'data' => $dataFullData,
//            'radniciFullData'=>$radniciCollection,
//            'selectPoenteri'=>$selectPoenteri,
//            'selectOdgovornaLica'=>$selectOdgovornaLica,
//            'maticnaSifarnik'=>$maticnaSifarnik
        ]);

    }

}
