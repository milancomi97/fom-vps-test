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
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PorezdoprinosiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\ObradaFormuleService;
use App\Modules\Obracunzarada\Service\ObradaObracunavanjeService;
use App\Modules\Obracunzarada\Service\ObradaPripremaService;
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
        private readonly DpsmAkontacijeRepositoryInterface                   $dpsmAkontacijeInterface,
        private readonly DpsmPoentazaslogRepositoryInterface                 $dpsmPoentazaslogInterface,
        private readonly DpsmFiksnaPlacanjaRepositoryInterface               $dpsmFiksnaPlacanjaInterface,
        private readonly DpsmKreditiRepositoryInterface                      $dpsmKreditiInterface,
        private readonly ObradaPripremaService                               $obradaPripremaService,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface       $dkopSveVrstePlacanjaInterface,
        private readonly PorezdoprinosiRepositoryInterface                   $porezdoprinosiInterface,
        private readonly ObradaObracunavanjeService                          $obradaObracunavanjeService,
        private readonly ObradaFormuleService                                $obradaFormuleService,
        private readonly MinimalnebrutoosnoviceRepositoryInterface           $minimalnebrutoosnoviceInterface,
        private readonly ObradaZaraPoRadnikuRepositoryInterface $obradaZaraPoRadnikuInterface
    )
    {
    }


    public function obradaIndex(Request $request)
    {


        $user_id = auth()->user()->id;
        $userPermission = UserPermission::where('user_id', $user_id)->first();
        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
        $id = $request->month_id;



        $this->dkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $id)->delete();
        $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id', $id)->delete();

//        $poenteriData = $this->mesecnatabelapoentazaInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id',$id)->select('vrste_placanja','user_id','maticni_broj','obracunski_koef_id')->get();
        $poenteriData = $this->mesecnatabelapoentazaInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id', $id)->get();

        // TODO podaci za formule start
        // $prviPodatakListaPlacanjaKojaSeObradjuje
        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
        $poresDoprinosiSifarnik = $this->porezdoprinosiInterface->getAll()->first();
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);
        $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($monthData->datum);

        // todo podaci za formule end

        $poenteriPrepared = $this->obradaPripremaService->pripremiUnosPoentera($poenteriData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData,$minimalneBrutoOsnoviceSifarnik);
//


        $allFiksnaPlacanjaData = $this->dpsmFiksnaPlacanjaInterface->with('maticnadatotekaradnika')->where('obracunski_koef_id', $id)->get();
        if ($allFiksnaPlacanjaData->count()) {
            $allFiksnaPlacanjaPrepared = $this->obradaPripremaService->pripremiFiksnaPlacanja($allFiksnaPlacanjaData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik);
            $status = $this->dkopSveVrstePlacanjaInterface->createMany($allFiksnaPlacanjaPrepared);
        }


//            $akontacijeData = $this->dpsmAkontacijeInterface->where('obracunski_koef_id',$id)->get();
//            $akontacijePrepared = $this->obradaPripremaService->pripremiAkontacije($akontacijeData);
//
        $varijabilnaData = $this->dpsmPoentazaslogInterface->where('obracunski_koef_id', $id)->get();
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



        $sveVrstePlacanjaDataSummarize = $this->obradaPripremaService->pripremaZaraPodatkePoRadnikuBezMinulogRada($sveVrstePlacanjaData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);

        // Logika za izracunavanje olaksice

//
//             $kreditiData = $this->dpsmKreditiInterface->where('obracunski_koef_id',$id)->get();
//             $kreditiPrepared =  $this->obradaPripremaService->pripremiKredita($kreditiData);


        //  LOGIKA G SLOV da se napravi promenljiva koja ce da sumira po radniku vrednosti
        // POK2 = G   ---

        // ZARA
        // prvi zbir SSZNNE = SATI ZARADE
        // IZNETO = sumiranje zarade
        //


        // G - Glavno
        // I - Medjuzbir,
        // K - Nema minuli rad,


        return redirect()->route('datotekaobracunskihkoeficijenata.obrada_radnik', ['obracunski_koef_id' => $id]);
//            return view('obracunzarada::obracunzarada.obracunzarada_index');

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


}
