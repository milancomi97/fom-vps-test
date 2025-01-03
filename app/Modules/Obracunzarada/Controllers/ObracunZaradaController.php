<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Service\ObradaObracunavanjeService;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;

class ObracunZaradaController extends Controller
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
        private readonly ObradaKreditiRepositoryInterface $obradaKreditiInterface,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly \App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly MinimalnebrutoosnoviceRepositoryInterface           $minimalnebrutoosnoviceInterface,

    )
    {
    }

    public function index()
    {
        return view('obracunzarada::obracunzarada.obracunzarada_index');
    }


    public function obradaRadnik(Request $request)
    {

        $monthId = $request->month_id;

//        (($podaci o firmi) ULICA OPSTINA PIB RACUN BANKE
//        Za mesec: 03.2024.(($formatirajDatum))
//        (($Ulica broj)) $((Grad)) //PREBACI LOGIKU U MDR da ne povlacis podatke
//        (($Naziv banke (tabela isplatnamesta->rbim_sifra_isplatnog_mesta == $mdrData['RBIM_isplatno_mesto_id'])) 03-001-10113/4}
//((Strucna sprema: $mdrData['RBPS_priznata_strucna_sprema'] treba logika da se izvuce))
//Radno mesto $mdrData['RBRM_radno_mesto'] treba logika da se izvuce naziv))


        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();

        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);

        $radnikMaticniId='123456';
        $radnikData = $this->obradaObracunavanjeService->pripremaPodatakaRadnik($monthId,$radnikMaticniId);

        $mdrData = collect($radnikData[0]->maticnadatotekaradnika);
        $mdrPreparedData = $this->obradaObracunavanjeService->pripremaMdrPodatakaRadnik($mdrData);

        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();

        $date = new \DateTime($podaciMesec->datum);
        $formattedDate = $date->format('m.Y');

        $dkopData = $this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get();


        $zarData = $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get()->first();
//       TODO $zaraData=

        return view('obracunzarada::obracunzarada.obracunzarada_radnik',
            [
                'radnikData' => $radnikData,
                'vrstePlacanjaData' => $sifarnikVrstePlacanja,
                'mdrData' => $mdrData,
                'podaciFirme' => $podaciFirme,
                'mdrPreparedData' => $mdrPreparedData,
                'dkopData' => $dkopData,
                'zarData' => $zarData,
                'datum' => $formattedDate,
                'podaciMesec' => $podaciMesec,
//                'zaraData'=>$zaraData
            ]);
    }


    public function emailRadnik(Request $request)
    {
        $mailData = [
            'title' => 'Naslov',
            'body' => 'Sadrzaj'
        ];

        Mail::to('snezat@gmail.com')->send(new DemoMail($mailData));
        Mail::to('dimitrijevicm1997@gmail.com')->send(new DemoMail($mailData));

        return redirect()->back();
    }

    public function showAllPlate(Request $request)
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

        return view('obracunzarada::obracunzarada.obracunzarada_show_all_plate',
            [
                'formattedDate' => $formattedDate,
                'monthData'=>$monthData,
                'mesecnaTabelaPotenrazaTable' => $mesecnaTabelaPotenrazaTable,
                'mesecnaTabelaPoentazaPermissions'=>$mesecnaTabelaPoentazaPermissions,
                'tableHeaders' => $tableHeaders,
                'vrstePlacanjaDescription'=>$this->vrsteplacanjaInterface->getVrstePlacanjaOpis(),
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'userPermission'=>$userPermission
            ]);
    }


    public function showPlate(Request $request)
    {

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

        $dkopData = $this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->orderBy('sifra_vrste_placanja')->get();


        $zarData = $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get()->first();
        $datumStampe = Carbon::now()->format('d. m. Y.');
        $kreditiData = $this->obradaKreditiInterface->where('obracunski_koef_id', $monthId)->where('user_mdr_id', $mdrData['id'])->get();
        $userData= User::where('maticni_broj',$radnikMaticniId)->first();
//        RBIM_isplatno_mesto_id
        $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($podaciMesec->datum);

        return view('obracunzarada::obracunzarada.obracunzarada_show_plate',
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
                'month_id'=>$request->month_id,
                'radnik_maticni'=>$radnikMaticniId,
                'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik
//                'zaraData'=>$zaraData
            ]);
    }


}
