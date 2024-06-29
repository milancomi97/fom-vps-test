<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmAkontacijeRepositoryInterface;
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
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\ObradaFormuleService;
use App\Modules\Obracunzarada\Service\ObradaObracunavanjeService;
use App\Modules\Obracunzarada\Service\ObradaPripremaService;
use App\Modules\Obracunzarada\Service\ObradaPripremaValidacijaService;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\UpdateNapomena;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use function Psy\debug;


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
        private readonly ArhiviranjeMesecaService $arhiviranjeMesecaService,
        private readonly PermesecnatabelapoentRepositoryInterface $permesecnatabelapoentInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface,
        private readonly ObradaKreditiRepositoryInterface                    $obradaKreditiInterface,

    )
    {
    }


    public function obradaIndex(Request $request)
    {
        $redirectUrl = $this->resolveRedirectUrl($request->redirect_url,$request->month_id);


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

        return response()->json(['id' => $id, 'status' => true, 'redirectUrl' => $redirectUrl]);

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

    public function resolveRedirectUrl($url,$monthId)
    {

        if ($url == 'obracunski_listovi') {
            return url('obracunzarada/datotekaobracunskihkoeficijenata/show_all_plate?month_id=').$monthId;
        } elseif ($url == 'rang_lista_zarada') {
            return url('obracunzarada/izvestaji/ranglistazarade?month_id=').$monthId;

        } elseif ($url == 'rekapitulacija_zarada') {
            return url('obracunzarada/izvestaji/rekapitulacijazarade?month_id=').$monthId;
        }


    }


    public function arhiviranjeMeseca(Request $request){

        $monthId= $request->month_id;
        $test='test';
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);
        $pristupi=$this->permesecnatabelapoentInterface->getAll();


       $data = $this->arhiviranjeMesecaService->getDataByMonthId($monthId);







        $datum = Carbon::createFromFormat('Y-m-d', $monthData->datum);

        // TODO 2. ARCHIVE
        $mdrData =$this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan',1)->get();
//        $mdrData = $this->arhiviranjeMesecaService->archiveMDR($mdrData,$datum);



        $dkopData = $this->dkopSveVrstePlacanjaInterface->getAll();
//        $dkopData = $this->arhiviranjeMesecaService->archiveDkop($dkopData,$datum);

        $zaraData = $this->obradaZaraPoRadnikuInterface->getAll();
//        $zaraData = $this->arhiviranjeMesecaService->archiveZara($zaraData,$datum);

//        $zaraData->each->delete();
//        $dkopData->each->delete();
//        $pristupi->each->delete();

        $varijabilna =$this->dpsmPoentazaslogInterface->getAll();
        $poenterData =$this->mesecnatabelapoentazaInterface->getAll();
        $varijabilnaData = $this->dpsmPoentazaslogInterface->getAll();

        // GLAVNA KREDITI
       $dpsmKrediti = $this->dpsmKreditiInterface->getAll();

       // POMOCNA KREDITI
        $obradaKrediti = $this->obradaKreditiInterface->getAll();

//        $this->obradaKreditiInterface->where('obracunski_koef_id', $id)->delete();
//        \App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface
//        $poenterData =$this->mesecnatabelapoentazaInterface->getAll();






        // TODO 1.UPDATE
        $mdrResult = $this->arhiviranjeMesecaService->getUpdateCurrentMDR($monthId);
        $kreditiData = $this->arhiviranjeMesecaService->updateKrediti($monthId);
        $monthData = $this->arhiviranjeMesecaService->updateCurrentMesecData($monthId);



















        // $fiksnaPlacanja = $this->arhiviranjeMesecaService->removeFiksnaPlacanja($monthId);

        // MDR DA SE POVECAJU PARAMETRI
        // KREDITI DA SE UPDATE
        // ZARA
        // DKOP
        // KREDITI POMOCNI
        // DA SE OCISTI Permisije za mesec
        // DA SE OCISTE NAPOMENE ZA MESEC
        // DA SE SACUVAJU NOVE ARHIVE SVA TRI KORAKA
        // DA SE PROMENI STATUS MESECA
        // POENTERSKI UNOS DA SE OCISTI
        // VARIJABILNI UNOS da se ocisti
        // UNOS FIKSNIH PLACANJA da se ocisti
        return response()->json(['status' => true]);

    }
}
