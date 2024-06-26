<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Modules\Obracunzarada\Repository\ArhivaDarhObradaSveDkopRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaMaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaSumeZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Service\ArhivaObracunavanjeService;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class ArhivaController extends Controller
{

    public function __construct(
        private readonly ArhivaMaticnadatotekaradnikaRepositoryInterface $arhivaMaticnadatotekaradnikaInterface,
        private readonly ArhivaSumeZaraPoRadnikuRepositoryInterface $arhivaSumeZaraPoRadnikuInterface,
        private readonly ArhivaDarhObradaSveDkopRepositoryInterface $arhivaDarhObradaSveDkopInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly PodaciofirmiRepositoryInterface                     $podaciofirmiInterface,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly ArhivaObracunavanjeService $arhivaObracunavanjeService,
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface       $obradaDkopSveVrstePlacanjaInterface,
        private readonly  MinimalnebrutoosnoviceRepositoryInterface $minimalnebrutoosnoviceInterface,
        private readonly VrsteplacanjaRepositoryInterface                    $vrsteplacanjaInterface,

    ){
    }



    public function index(Request $request)
    {

        $radniciSelectData=[];
       $data = $this->maticnadatotekaradnikaInterface->getAll();

       foreach ($data as $radnik){
           $test='test';
           $radniciSelectData[]=['id'=>$radnik->MBRD_maticni_broj ,'text'=>$radnik->MBRD_maticni_broj.' '. $radnik->PREZIME_prezime .' '.  $radnik->srednje_ime.' '.  $radnik->IME_ime];
       }

       $test='test';
        return view('obracunzarada::arhiva.arhiva_index',['radniciSelectData'=>$radniciSelectData]);
    }

    public function mesec(Request $request)
    {


        $arhiva_datum=$request->arhiva_datum;

        return view('obracunzarada::arhiva.arhiva_mesec',['arhiva_datum'=>$arhiva_datum]);
    }

    public function radnik(Request $request)
    {


        return view('obracunzarada::arhiva.arhiva_radnik');
    }

    public function arhivaMaticneDatoteke(Request $request)
    {
        $maticniBroj = $request->maticniBroj;
        $datum = $request->datum;

// Parse the input date to get the start and end of the month
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();
        $startDate = $startOfMonth->format('Y-m-d');

// Retrieve records using Eloquent
        $arhivaMdr =$this->arhivaMaticnadatotekaradnikaInterface->where('M_G_date', $startDate)->where('MBRD_maticni_broj',$maticniBroj)->get();



        $radniciSelectData=[];
        $data = $this->maticnadatotekaradnikaInterface->getAll();

        foreach ($data as $radnik){
            $test='test';
            $radniciSelectData[]=['id'=>$radnik->MBRD_maticni_broj ,'text'=>$radnik->MBRD_maticni_broj.' '. $radnik->PREZIME_prezime .' '.  $radnik->srednje_ime.' '.  $radnik->IME_ime];
        }



        return view('obracunzarada::arhiva.arhiva_maticne_datoteke',['arhivaMdr'=>$arhivaMdr,'archiveDate'=>$datum,'radniciSelectData'=>$radniciSelectData]);
    }
    public function obracunskeListe(Request $request)
    {
        $maticniBroj = $request->maticniBroj;
        $datum = $request->datum;
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();
        $startDate = $startOfMonth->format('Y-m-d');
        $zaraData =$this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date', $startDate)->where('maticni_broj',$maticniBroj)->get()->first();
        $dkopData = $this->arhivaDarhObradaSveDkopInterface->where('M_G_date', $startDate)->where('maticni_broj',$maticniBroj)->get();

        $test='test';
        $data = $this->maticnadatotekaradnikaInterface->getAll();

        foreach ($data as $radnik){
            $test='test';
            $radniciSelectData[]=['id'=>$radnik->MBRD_maticni_broj ,'text'=>$radnik->MBRD_maticni_broj.' '. $radnik->PREZIME_prezime .' '.  $radnik->srednje_ime.' '.  $radnik->IME_ime];
        }
        $radniciSelectData[]=['id'=>$radnik->MBRD_maticni_broj ,'text'=>$radnik->MBRD_maticni_broj.' '. $radnik->PREZIME_prezime .' '.  $radnik->srednje_ime.' '.  $radnik->IME_ime];

        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();

        $datumStampe = \Carbon\Carbon::now()->format('d.m.Y');


//        $mdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$startDate)->get()->first();
        $arhivaMdr =$this->arhivaMaticnadatotekaradnikaInterface->where('M_G_date', $startDate)->where('MBRD_maticni_broj',$maticniBroj)->get()->first();
        $mdrDataCollection = collect($arhivaMdr);
        $mdrPreparedData = $this->arhivaObracunavanjeService->pripremaMdrPodatakaRadnik($mdrDataCollection);
        $troskovnoMesto = $this->organizacionecelineInterface->getById($mdrDataCollection['troskovno_mesto_id']);
        $userData= User::where('maticni_broj',$maticniBroj)->first();

        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->where('datum',$startDate)->get()->first();


        $radnikData = $this->arhivaObracunavanjeService->pripremaPodatakaRadnik($startDate,$maticniBroj);




        // Get by DATE datotekaobracunskih koeficijenata
        return view('obracunzarada::arhiva.obracunske_liste',[
            'zarData'=>$zaraData,
            'dkopData'=>$dkopData,
            'datum'=>$datum,
            'datumStampe'=>$datumStampe,
            'radniciSelectData'=>$radniciSelectData,
            'podaciFirme' => $podaciFirme,
            'mdrPreparedData' => $mdrPreparedData,
            'troskovnoMesto'=> $troskovnoMesto,
            'mdrData' => $mdrDataCollection,
            'userData'=>$userData,
            'podaciMesec' => $podaciMesec,
            'radnikData' => $radnikData,
        ]);
    }
    public function ukupnaRekapitulacija(Request $request)
    {
        $datum = $request->datum;
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();

        $startDate = $startOfMonth->format('Y-m-d');


        $monthData = $this->datotekaobracunskihkoeficijenataInterface->where('datum', $startDate);
        $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($startDate);
        $dkopData =$this->arhivaDarhObradaSveDkopInterface
            ->where('M_G_date', $startDate)
            ->orderBy('sifra_vrste_placanja')
            ->groupBy('sifra_vrste_placanja','naziv_vrste_placanja')
            ->selectRaw('sifra_vrste_placanja,naziv_vrste_placanja, SUM(iznos) as iznos, SUM(sati) as sati')
            ->get();


        $zaraData =$this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date', $startDate)
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
        return view('obracunzarada::arhiva.ukupna_rekapitulacija',[
            'archiveDate'=>$datum,
            'dkopData'=>$dkopData,
            'zaraData'=>$zaraData,
            'vrstePlacanjaSifarnik'=>$vrstePlacanjaSifarnik,
            'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik
        ]);
    }

    public function potvrdaProseka(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;

        return view('obracunzarada::arhiva.potvrda_proseka');
    }

    public function godisnjiKarton(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;
        return view('obracunzarada::arhiva.godisnji_karton');
    }

    public function pppPrijava(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;
        return view('obracunzarada::arhiva.ppp_prijava');
    }

}
