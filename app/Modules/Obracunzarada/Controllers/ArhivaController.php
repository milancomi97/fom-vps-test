<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Modules\Obracunzarada\Consts\UserRoles;
use App\Modules\Obracunzarada\Repository\ArhivaDarhObradaSveDkopRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaMaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaSumeZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Service\ArhivaObracunavanjeService;
use App\Modules\Obracunzarada\Service\ObradaObracunavanjeService;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class ArhivaController extends Controller
{

    public function __construct(
        private readonly ArhivaMaticnadatotekaradnikaRepositoryInterface     $arhivaMaticnadatotekaradnikaInterface,
        private readonly ArhivaSumeZaraPoRadnikuRepositoryInterface          $arhivaSumeZaraPoRadnikuInterface,
        private readonly ArhivaDarhObradaSveDkopRepositoryInterface          $arhivaDarhObradaSveDkopInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface           $maticnadatotekaradnikaInterface,
        private readonly PodaciofirmiRepositoryInterface                     $podaciofirmiInterface,
        private readonly OrganizacionecelineRepositoryInterface              $organizacionecelineInterface,
        private readonly ArhivaObracunavanjeService                          $arhivaObracunavanjeService,
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface       $obradaDkopSveVrstePlacanjaInterface,
        private readonly MinimalnebrutoosnoviceRepositoryInterface           $minimalnebrutoosnoviceInterface,
        private readonly VrsteplacanjaRepositoryInterface                    $vrsteplacanjaInterface,
        private readonly ObradaObracunavanjeService $obradaObracunavanjeService,
        private readonly ObradaZaraPoRadnikuRepositoryInterface $obradaZaraPoRadnikuInterface,
    )
    {
    }



    public function index(Request $request)
    {
        $userData = Auth::user()->load(['permission']);
        $permissions = $userData->permission;

//        @if(auth()->user()->userPermission->role_id==UserRoles::SUPERVIZOR)


        $radniciSelectData = [];
        $data = $this->maticnadatotekaradnikaInterface->getAll();


        foreach ($data as $radnik) {
            $test = 'test';

            if($radnik->BRCL_redosled_poentazi < 100 &&  $permissions->role_id!==UserRoles::SUPERVIZOR){

                $ttest='test';
                continue;


            }
            $radniciSelectData[] = ['id' => $radnik->MBRD_maticni_broj, 'text' => $radnik->MBRD_maticni_broj . ' ' . $radnik->PREZIME_prezime . ' ' . $radnik->srednje_ime . ' ' . $radnik->IME_ime];
        }

        $test = 'test';
        return view('obracunzarada::arhiva.arhiva_index', ['radniciSelectData' => $radniciSelectData]);
    }

    public function mesec(Request $request)
    {


        $arhiva_datum = $request->arhiva_datum;

        return view('obracunzarada::arhiva.arhiva_mesec', ['arhiva_datum' => $arhiva_datum]);
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
        $arhivaMdr = $this->arhivaMaticnadatotekaradnikaInterface->where('M_G_date', $startDate)->where('MBRD_maticni_broj', $maticniBroj)->get();


        $radniciSelectData = [];
        $data = $this->maticnadatotekaradnikaInterface->getAll();

        foreach ($data as $radnik) {
            $test = 'test';
            $radniciSelectData[] = ['id' => $radnik->MBRD_maticni_broj, 'text' => $radnik->MBRD_maticni_broj . ' ' . $radnik->PREZIME_prezime . ' ' . $radnik->srednje_ime . ' ' . $radnik->IME_ime];
        }


        return view('obracunzarada::arhiva.arhiva_maticne_datoteke', ['arhivaMdr' => $arhivaMdr, 'archiveDate' => $datum, 'radniciSelectData' => $radniciSelectData]);
    }

    public function obracunskeListe(Request $request)
    {
        $maticniBroj = $request->maticniBroj;
        $datum = $request->datum;
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();
        $startDate = $startOfMonth->format('Y-m-d');
        $zaraData = $this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date', $startDate)->where('maticni_broj', $maticniBroj)->get()->first();
        $dkopData = $this->arhivaDarhObradaSveDkopInterface->where('M_G_date', $startDate)->where('maticni_broj', $maticniBroj)->get();

        $test = 'test';
        $data = $this->maticnadatotekaradnikaInterface->getAll();

        foreach ($data as $radnik) {
            $test = 'test';
            $radniciSelectData[] = ['id' => $radnik->MBRD_maticni_broj, 'text' => $radnik->MBRD_maticni_broj . ' ' . $radnik->PREZIME_prezime . ' ' . $radnik->srednje_ime . ' ' . $radnik->IME_ime];
        }
        $radniciSelectData[] = ['id' => $radnik->MBRD_maticni_broj, 'text' => $radnik->MBRD_maticni_broj . ' ' . $radnik->PREZIME_prezime . ' ' . $radnik->srednje_ime . ' ' . $radnik->IME_ime];

        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();

        $datumStampe = \Carbon\Carbon::now()->format('d. m. Y.');


//        $mdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$startDate)->get()->first();
        $arhivaMdr = $this->arhivaMaticnadatotekaradnikaInterface->where('M_G_date', $startDate)->where('MBRD_maticni_broj', $maticniBroj)->get()->first();
        $mdrDataCollection = collect($arhivaMdr);
        $mdrPreparedData = $this->arhivaObracunavanjeService->pripremaMdrPodatakaRadnik($mdrDataCollection);
        $troskovnoMesto = $this->organizacionecelineInterface->getById($mdrDataCollection['troskovno_mesto_id']);
        $userData = User::where('maticni_broj', $maticniBroj)->first();

        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->where('datum', $startDate)->get()->first();


        $radnikData = $this->arhivaObracunavanjeService->pripremaPodatakaRadnik($startDate, $maticniBroj);


        // Get by DATE datotekaobracunskih koeficijenata
        return view('obracunzarada::arhiva.obracunske_liste', [
            'zarData' => $zaraData,
            'dkopData' => $dkopData,
            'datum' => $datum,
            'datumStampe' => $datumStampe,
            'radniciSelectData' => $radniciSelectData,
            'podaciFirme' => $podaciFirme,
            'mdrPreparedData' => $mdrPreparedData,
            'troskovnoMesto' => $troskovnoMesto,
            'mdrData' => $mdrDataCollection,
            'userData' => $userData,
            'podaciMesec' => $podaciMesec,
            'radnikData' => $radnikData,
            'radnik_maticni'=>$maticniBroj
        ]);
    }

    public function ukupnaRekapitulacija(Request $request)
    {
        $datum = $request->datum;
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();

        $startDate = $startOfMonth->format('Y-m-d');


        $monthData = $this->datotekaobracunskihkoeficijenataInterface->where('datum', $startDate);
        $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($startDate);
        $dkopData = $this->arhivaDarhObradaSveDkopInterface
            ->where('M_G_date', $startDate)
            ->orderBy('sifra_vrste_placanja')
            ->groupBy('sifra_vrste_placanja', 'naziv_vrste_placanja')
            ->selectRaw('sifra_vrste_placanja,naziv_vrste_placanja, SUM(iznos) as iznos, SUM(sati) as sati')
            ->get();


        $zaraData = $this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date', $startDate)
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
        return view('obracunzarada::arhiva.ukupna_rekapitulacija', [
            'archiveDate' => $datum,
            'datum' => $datum,
            'dkopData' => $dkopData,
            'zaraData' => $zaraData,
            'vrstePlacanjaSifarnik' => $vrstePlacanjaSifarnik,
            'minimalneBrutoOsnoviceSifarnik' => $minimalneBrutoOsnoviceSifarnik
        ]);
    }

    public function potvrdaProseka(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;


        $startPeriod = Carbon::createFromFormat('m.Y', $datumOd)->startOfMonth();
        $endPeriod = Carbon::createFromFormat('m.Y', $datumDo)->endOfMonth();

// Izračunaj broj meseci
        $monthsDifference = $startPeriod->diffInMonths($endPeriod);

// Kreiraj listu datuma između perioda
        $period = CarbonPeriod::create($startPeriod, '1 month', $endPeriod);

        $listOfDates = [];
        foreach ($period as $date) {
            $listOfDates[] = $date->format('Y-m-d');
        }

        $sumeZaraPeriod = $this->arhivaSumeZaraPoRadnikuInterface->whereIn('M_G_date', $listOfDates)->where('maticni_broj', $maticniBroj)->get();

        $resultData = [];
        $resultData['izneto'] = 0;
        $resultData['neto'] = 0;
        foreach ($sumeZaraPeriod as $mesecData) {
            $resultData[] = [
                'IZNETO' => $mesecData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade,
                'NETO' => $mesecData->NETO_neto_zarada,
                'datum' => $mesecData->M_G_date
            ];

            $resultData['izneto']+= $mesecData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade;
            $resultData['neto'] +=$mesecData->NETO_neto_zarada;

        }
        $radnikData =User::where('maticni_broj',$maticniBroj)->get()->first();

        $test = 'test';

        return view('obracunzarada::arhiva.potvrda_proseka',[
            'resultData'=>$resultData,
            'radnikData'=>$radnikData,
            'datumOd'=>$datumOd,
            'datumDo'=>$datumDo,
            'maticniBroj'=>$maticniBroj
        ]);
    }


    public function stampaPotvrdaProseka(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;


        $startPeriod = Carbon::createFromFormat('m.Y', $datumOd)->startOfMonth();
        $endPeriod = Carbon::createFromFormat('m.Y', $datumDo)->endOfMonth();

// Izračunaj broj meseci
        $monthsDifference = $startPeriod->diffInMonths($endPeriod);

// Kreiraj listu datuma između perioda
        $period = CarbonPeriod::create($startPeriod, '1 month', $endPeriod);

        $listOfDates = [];
        foreach ($period as $date) {
            $listOfDates[] = $date->format('Y-m-d');
        }

        $sumeZaraPeriod = $this->arhivaSumeZaraPoRadnikuInterface->whereIn('M_G_date', $listOfDates)->where('maticni_broj', $maticniBroj)->get();

        $resultData = [];
        $resultData['izneto'] = 0;
        $resultData['neto'] = 0;
        $counter=0;
        foreach ($sumeZaraPeriod as $mesecData) {
            $resultData[] = [
                'IZNETO' => $mesecData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade,
                'NETO' => $mesecData->NETO_neto_zarada,
                'datum' => $mesecData->M_G_date
            ];
            $counter++;

            $resultData['izneto']+= $mesecData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade;
            $resultData['neto'] +=$mesecData->NETO_neto_zarada;

        }

        $resultData['brojMeseci']=$counter;
        $radnikData =User::where('maticni_broj',$maticniBroj)->get()->first();

        $mdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$maticniBroj)->get()->first();

        set_time_limit(0);
        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();
        $datumStampe = \Carbon\Carbon::now()->format('d. m. Y.');

        $pdf = PDF::loadView('obracunzarada::arhiva.potvrda_proseka_export_pdf',[
            'resultData'=>$resultData,
            'radnikData'=>$radnikData,
            'datumOd'=>$datumOd,
            'datumDo'=>$datumDo,
            'opis'=>$request->opis,
            'podaciFirme'=>$podaciFirme,
            'datumStampe'=>$datumStampe,
            'mdrData'=>$mdrData
        ])->setPaper('a4', 'portrait');


        return $pdf->download('potvrda_proseka_'.$maticniBroj.'_'.date("d.m.y").'.pdf');

    }

    public function godisnjiKarton(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;
        return view('obracunzarada::arhiva.godisnji_karton');
    }





    public function pppPrijavaForm(Request $request)
    {



        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;

        if(isset($request->maticniBroj)){
            $zaraData = $this->obradaZaraPoRadnikuInterface->getAll();


        }else{
            $zaraData = $this->obradaZaraPoRadnikuInterface->getAll();

        }
//        Ukupna zarada   Uplaceni deo zarade               Razlika
//    **********************************************************************************************************
//                           Bruto zarada:             143021.35                  0.00             143021.35
//                     Osnovica za poreze:             143021.35                  0.00             143021.35
//                                  Porez:              11802.14                  0.00              11802.14
//                   Poresko oslobodjenje:              25000.00                  0.00              25000.00
//                   Pio na teret radnika:              20022.99                  0.00              20022.99
//                Pio na teret poslodavca:              14302.14                  0.00              14302.14
//             Zdravstvo na teret radnika:               7365.60                  0.00               7365.60
//          Zdravstvo na teret poslodavca:               7365.60                  0.00               7365.60
//            Nezaposlenost na teret rad.:               1072.66                  0.00               1072.66
//            Nezaposlenost na teret pos.:                  0.00                  0.00                  0.00

//        $xmlContent = View::make('obracunzarada::poreskaprijava.ppp_prijava', [
//            'radnikData'=>$zaraData
//        ])->render();

        $xmlContent='';
        return view('obracunzarada::poreskaprijava.ppp_prijava_form', ['xmlContent' => $xmlContent]);

    }


    public function pppPrijava(Request $request)
    {


        $datum_nastanka= Carbon::parse($request->datum_nastanka)->format('Y-m-d');
        $datum_placanja= Carbon::parse($request->datum_placanja)->format('Y-m-d');
        $preduzece_budzet=$request->preduzece_budzet;
        $obracunski_period_month= $request->obracunski_period_month;
        $obracunski_period_year= $request->obracunski_period_year;
        $konacno=$request->konacno;
//        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);

//        $podaciMesec->datum=date('m.Y', strtotime($podaciMesec->datum));

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;
        if(isset($request->maticniBroj)){
            $zaraData = $this->obradaZaraPoRadnikuInterface->with('maticnadatotekaradnika')->getAll();


    }else{
            $zaraData = $this->obradaZaraPoRadnikuInterface->getAll();

        }
//        Ukupna zarada   Uplaceni deo zarade               Razlika
//    **********************************************************************************************************
//                           Bruto zarada:             143021.35                  0.00             143021.35
//                     Osnovica za poreze:             143021.35                  0.00             143021.35
//                                  Porez:              11802.14                  0.00              11802.14
//                   Poresko oslobodjenje:              25000.00                  0.00              25000.00
//                   Pio na teret radnika:              20022.99                  0.00              20022.99
//                Pio na teret poslodavca:              14302.14                  0.00              14302.14
//             Zdravstvo na teret radnika:               7365.60                  0.00               7365.60
//          Zdravstvo na teret poslodavca:               7365.60                  0.00               7365.60
//            Nezaposlenost na teret rad.:               1072.66                  0.00               1072.66
//            Nezaposlenost na teret pos.:                  0.00                  0.00                  0.00

        $podaciOFirmi=$this->podaciofirmiInterface->getAll()->first();
        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->where('datum', $obracunski_period_year.'-'.$obracunski_period_month.'-01')->get()->first();


        $xmlContent = View::make('obracunzarada::poreskaprijava.ppp_prijava', [
            'radnikData'=>$zaraData,
            'podaciOFirmi'=>$podaciOFirmi,
            'datum_nastanka'=>$datum_nastanka,
            'datum_placanja'=>$datum_placanja,
            'preduzece_budzet'=>$preduzece_budzet,
            'obracunski_period_month'=>$obracunski_period_month,
            'obracunski_period_year'=>$obracunski_period_year,
            'konacno'=>$konacno,
            'podaciMesec'=>$podaciMesec
        ])->render();


        $dataInput=[
            'datum_nastanka'=> $request->datum_nastanka,
         'datum_placanja'=>   $request->datum_placanja,
          'preduzece_budzet'=>  $request->preduzece_budzet,
          'obracunski_period_month'=>  $request->obracunski_period_month,
          'obracunski_period_year'=>  $request->obracunski_period_year,
          'konacno'=>  $request->konacno,
          'maticniBroj'=>  $request->maticniBroj,
        ];
        return view('obracunzarada::poreskaprijava.ppp_prijava_check', ['xmlContent' => $xmlContent,'fileInputs'=>$dataInput]);

    }


    public function pppPrijavaDownload(Request $request)
    {
        // Retrieve or re-generate the XML content as needed
        $datum_nastanka= Carbon::parse($request->datum_nastanka)->format('Y-m-d');
        $datum_placanja= Carbon::parse($request->datum_placanja)->format('Y-m-d');
        $preduzece_budzet=$request->preduzece_budzet;
        $obracunski_period_month= $request->obracunski_period_month;
        $obracunski_period_year= $request->obracunski_period_year;
        $konacno=$request->konacno;
//        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->getById($monthId);

//        $podaciMesec->datum=date('m.Y', strtotime($podaciMesec->datum));

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;
        if(isset($request->maticniBroj)){
            $zaraData = $this->obradaZaraPoRadnikuInterface->with('maticnadatotekaradnika')->getAll();


        }else{
            $zaraData = $this->obradaZaraPoRadnikuInterface->getAll();

        }

        $podaciOFirmi=$this->podaciofirmiInterface->getAll()->first();
        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->where('datum', $obracunski_period_year.'-'.$obracunski_period_month.'-01')->get()->first();

        $xmlContent = View::make('obracunzarada::poreskaprijava.ppp_prijava', [
            'radnikData'=>$zaraData,
            'podaciOFirmi'=>$podaciOFirmi,
            'datum_nastanka'=>$datum_nastanka,
            'datum_placanja'=>$datum_placanja,
            'preduzece_budzet'=>$preduzece_budzet,
            'obracunski_period_month'=>$obracunski_period_month,
            'obracunski_period_year'=>$obracunski_period_year,
            'konacno'=>$konacno,
            'podaciMesec'=>$podaciMesec
        ])->render();

        // Return XML file as a download
        return Response::make($xmlContent, 200, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="prijava_za_'.$obracunski_period_month.'.'.$obracunski_period_year.'.xml"',
        ]);
    }

    public function stampaArhivaRadnikLista(Request $request){

        $datum = $request->datum;

        $radnikMaticniId=$request->radnik_maticni;

        $podaciFirme = $this->podaciofirmiInterface->getAll()->first()->toArray();

        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();
        $startDate = $startOfMonth->format('Y-m-d');
        $podaciMesec = $this->datotekaobracunskihkoeficijenataInterface->where('datum', $startDate)->get()->first();

        $zaraData = $this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date', $startDate)->where('maticni_broj', $radnikMaticniId)->get()->first();
        $dkopData = $this->arhivaDarhObradaSveDkopInterface->where('M_G_date', $startDate)->where('maticni_broj', $radnikMaticniId)->get();

        $arhivaMdr = $this->arhivaMaticnadatotekaradnikaInterface->where('M_G_date', $startDate)->where('MBRD_maticni_broj', $radnikMaticniId)->get()->first();

        $mdrDataCollection = collect($arhivaMdr);

        $mdrPreparedData = $this->arhivaObracunavanjeService->pripremaMdrPodatakaRadnik($mdrDataCollection);

        $troskovnoMesto = $this->organizacionecelineInterface->getById($mdrDataCollection['troskovno_mesto_id']);

        $userData = User::where('maticni_broj', $radnikMaticniId)->first();

        $radnikData = $this->arhivaObracunavanjeService->pripremaPodatakaRadnik($startDate, $radnikMaticniId);

        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();
        $datumStampe = \Carbon\Carbon::now()->format('d. m. Y.');

        set_time_limit(0);

        $pdf = PDF::loadView('obracunzarada::izvestaji.obracunzarada_show_plate_export_pdf',
            [
                'radnikData' => $radnikData,
                'userData'=>$userData,
                'vrstePlacanjaData' => $sifarnikVrstePlacanja,
                'mdrData' => $arhivaMdr,
                'podaciFirme' => $podaciFirme,
                'mdrPreparedData' => $mdrPreparedData,
                'dkopData' => $dkopData,
                'zarData' => $zaraData,
//                'kreditiData'=>$kreditiData,
                'datum' => $datum,
                'podaciMesec' => $podaciMesec,
                'troskovnoMesto'=> $troskovnoMesto,
                'datumStampe'=>$datumStampe,
                'month_id'=>$request->month_id
            ])->setPaper('a4', 'portrait');


        return $pdf->download('arhiva_radnik_lista_'.$radnikMaticniId.'_'.date("d.m.y").'.pdf');


    }

    public function stampaArhivaOstvareneZarade(Request $request){

        $datum = $request->datum;
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();

        $startDate = $startOfMonth->format('Y-m-d');


        $monthData = $this->datotekaobracunskihkoeficijenataInterface->where('datum', $startDate);
        $minimalneBrutoOsnoviceSifarnik = $this->minimalnebrutoosnoviceInterface->getDataForCurrentMonth($startDate);
        $dkopData = $this->arhivaDarhObradaSveDkopInterface
            ->where('M_G_date', $startDate)
            ->orderBy('sifra_vrste_placanja')
            ->groupBy('sifra_vrste_placanja', 'naziv_vrste_placanja')
            ->selectRaw('sifra_vrste_placanja,naziv_vrste_placanja, SUM(iznos) as iznos, SUM(sati) as sati')
            ->get();


        $zaraData = $this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date', $startDate)
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
        $datumStampe = \Carbon\Carbon::now()->format('d. m. Y.');


        $pdf = PDF::loadView('obracunzarada::arhiva.rekapitulacija_zarade_export_pdf',
            [
                'dkopData'=>$dkopData,
                'zaraData'=>$zaraData,
                'vrstePlacanjaSifarnik'=>$vrstePlacanjaSifarnik,
                'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik,
                'aktivnihRadnika'=>0,
                'radnikaSaZaradom'=>0,
                'datum'=>$datum,
                'podaciFirme'=>$podaciFirme,
                'datumStampe'=>$datumStampe

            ])->setPaper('a4', 'portrait');

        return $pdf->download('pdf_ostvarene_zarade_'.date("d.m.y").'.pdf');
    }

    public function stampaArhivaRangListe(Request $request){
        $test='test';

    }
}
