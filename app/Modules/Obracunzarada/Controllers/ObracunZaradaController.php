<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Service\ObradaObracunavanjeService;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Illuminate\Http\Request;

class ObracunZaradaController extends Controller
{

    public function __construct(
        private readonly ObradaObracunavanjeService $obradaObracunavanjeService,
        private readonly VrsteplacanjaRepositoryInterface $vrsteplacanjaInterface,
        private readonly PodaciofirmiRepositoryInterface $podaciofirmiInterface,
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface $obradaDkopSveVrstePlacanjaInterface
    )
    {
    }

    public function index(){
        return view('obracunzarada::obracunzarada.obracunzarada_index');
    }


    public function obradaRadnik(Request $request){

        $id= $request->obracunski_koef_id;

//        (($podaci o firmi) ULICA OPSTINA PIB RACUN BANKE
//        Za mesec: 03.2024.(($formatirajDatum))
//        (($Ulica broj)) $((Grad)) //PREBACI LOGIKU U MDR da ne povlacis podatke
//        (($Naziv banke (tabela isplatnamesta->rbim_sifra_isplatnog_mesta == $mdrData['RBIM_isplatno_mesto_id'])) 03-001-10113/4}
//((Strucna sprema: $mdrData['RBPS_priznata_strucna_sprema'] treba logika da se izvuce))
//Radno mesto $mdrData['RBRM_radno_mesto'] treba logika da se izvuce naziv))


        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();

        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($id);


        $radnikData = $this->obradaObracunavanjeService->pripremaPodatakaRadnik($id);

        $mdrData = collect($radnikData[0]->maticnadatotekaradnika);
        $mdrPreparedData = $this->obradaObracunavanjeService->pripremaMdrPodatakaRadnik($mdrData);

        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();

        $date = new \DateTime($podaciMesec->datum);
        $formattedDate = $date->format('m.Y');

        $dkopData = $this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id',$id)->where('user_mdr_id',$mdrData['id'])->get();

        return view('obracunzarada::obracunzarada.obracunzarada_radnik',
            [
                'radnikData'=>$radnikData,
                'vrstePlacanjaData'=>$sifarnikVrstePlacanja,
                'mdrData'=>$mdrData,
                'podaciFirme'=>$podaciFirme,
                'mdrPreparedData'=>$mdrPreparedData,
                'dkopData'=>$dkopData,
                'datum'=>$formattedDate,
                'podaciMesec'=>$podaciMesec
            ]);
    }


}
