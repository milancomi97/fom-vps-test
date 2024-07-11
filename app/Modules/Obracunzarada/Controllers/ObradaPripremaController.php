<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Datotekaobracunskihkoeficijenata;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\ArhivaSumeZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
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
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use \Carbon\Carbon;


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


    )
    {
    }


    public function obradaIndex(Request $request)
    {


        if ($request->redirect_url == 'obrada_plate') {


            $user_id = auth()->user()->id;
            $userPermission = UserPermission::where('user_id', $user_id)->first();
            $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
            $id = $request->month_id;

            $this->dkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $id)->delete();
            $this->obradaKreditiInterface->where('obracunski_koef_id', $id)->delete();
            $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id', $id)->delete();

//        $poenteriData = $this->mesecnatabelapoentazaInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id',$id)->select('vrste_placanja','user_id','maticni_broj','obracunski_koef_id')->get();
            $poenteriData = $this->mesecnatabelapoentazaInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id', $id)->get();

            // $prviPodatakListaPlacanjaKojaSeObradjuje
            $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
            $poresDoprinosiSifarnik = $this->porezdoprinosiInterface->getAll()->first();

            $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
            $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($monthData->datum);
            $poenteriPrepared = $this->obradaPripremaService->pripremiUnosPoentera($poenteriData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);
//


            $allFiksnaPlacanjaData = $this->dpsmFiksnaPlacanjaInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id', $id)->get();
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

            try {
                $sveVrstePlacanjaDataSummarize = $this->obradaPripremaService->pripremaZaraPodatkePoRadnikuBezMinulogRada($sveVrstePlacanjaData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);
            } catch (\Throwable $exception) {
                report($exception);
                $newMessage = "Greska u obradi:";
                return response()->json(['status' => false, 'message' => 'Greska u obradi: ' . $exception->getMessage()]);

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
        $pristupi = $this->permesecnatabelapoentInterface->getAll();

        // glavnaKrediti
        $dpsmKrediti = $this->dpsmKreditiInterface->getAll();
        // POMOCNA KREDITI
        $kreditiPomocni = $this->obradaKreditiInterface->getAll();


        $zaraDataResult = $this->arhiviranjeMesecaService->resolveKrediti($dpsmKrediti, $kreditiPomocni);


        $this->dkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $monthId)->delete();
        $this->obradaKreditiInterface->where('obracunski_koef_id', $monthId)->delete();

        $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id', $monthId)->delete();


        $pristupi->each->delete();
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
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);
//        $datum = Carbon::createFromFormat('Y-m-d', $monthData->datum)->startOfMonth();
//        $periodDo = $datum->format('m.Y');
//        $startOfMonth = \Illuminate\Support\Carbon::createFromFormat('m.Y', $datum)->startOfMonth();

        $zarData = $this->obradaZaraPoRadnikuInterface->getById($request->month_id);
//        $zarSumeData = $this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date')->get();
        $test='test';


        $startPeriod = \Illuminate\Support\Carbon::createFromFormat('m.Y', $periodOd)->startOfMonth();
//        $endPeriod = Carbon::createFromFormat('m.Y', $datumDo)->endOfMonth();
        $startDate = $startPeriod->format('Y-m-d');

// Izračunaj broj meseci
        $monthsDifference = $startPeriod->diffInMonths($monthData->datum);

// Kreiraj listu datuma između perioda
        $period = CarbonPeriod::create($startDate, '1 month', $monthData->datum);

        $listOfDates = [];
        foreach ($period as $date) {
            $listOfDates[] = $date->format('Y-m-d');
        }

//        $sumeZaraPeriod = $this->arhivaSumeZaraPoRadnikuInterface->whereIn('M_G_date', $listOfDates)->get();


        $sumeZaraPeriodBetween = $this->arhivaSumeZaraPoRadnikuInterface->between('M_G_date', $startPeriod, $monthData->datum)->get();


        $activeMDR = $this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan',1)->pluck('ACTIVE_aktivan','MBRD_maticni_broj')->toArray();

        $zaraSummarize = $this->arhivaSumeZaraPoRadnikuInterface
            ->between('M_G_date', $startPeriod, $monthData->datum)
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




        foreach ($sumResult as $maticniBroj => $radnik){
           $mdr=  $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$maticniBroj)->where('ACTIVE_aktivan',1)->first();

            if($mdr!==null){
                $mdr->PRIZ_ukupan_bruto_iznos =$radnik['PRIZ_prosecni_iznos_godina'];
                $mdr->PRCAS_ukupni_sati_za_ukupan_bruto_iznost=$radnik['PRCAS_prosecni_sati_godina'];
                $mdr->BROJ_broj_meseci_za_obracun=$radnik['broj_meseci'];
                $mdr->save();
            }
        }

        $updatedMdr = $this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan',1)->get();

        $test='test';

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_obrada_proseka_prikaz',['sumResult'=>$updatedMdr]);
    }


    public function prikazPoVrstiPlacanja(Request $request){

        $test='test';
    }

    public function formaPoVrstiPlacanja(Request $request)
    {
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($request->month_id);

        $selectOptionData =$this->dkopSveVrstePlacanjaInterface->getAll()->unique('sifra_vrste_placanja')->pluck('naziv_vrste_placanja','sifra_vrste_placanja')->toArray();;

        ksort($selectOptionData);
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_form_po_vrsti_placanja',[
            'selectOptionData'=>$selectOptionData
        ]);

        $test='test';
    }
}
