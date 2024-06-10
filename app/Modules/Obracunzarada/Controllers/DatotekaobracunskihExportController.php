<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Exports\PoenterUnosExport;
use App\Http\Controllers\Controller;
use App\Models\Datotekaobracunskihkoeficijenata;
use App\Models\UserPermission;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmAkontacijeRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\MesecValidationService;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\ProveraPoentazeService;
use App\Modules\Obracunzarada\Service\UpdateNapomena;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use function Psy\debug;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;


class DatotekaobracunskihExportController extends Controller
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
        private readonly  MinimalnebrutoosnoviceRepositoryInterface $minimalnebrutoosnoviceInterface

    )
    {
    }


    public function odobravanjeExportXls(Request $request)
    {
        $user_id = auth()->user()->id;

        $userPermission = UserPermission::where('user_id', $user_id)->first();

        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
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
        $test = 'testt';

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

    public function stampaRadnikLista(Request $request){


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

        $test='test';

    }



    public function stampaRangListe(Request $request){

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

        return view('obracunzarada::izvestaji.ranglista_zarade_export_pdf',
            ['groupedZara'=>$groupedZara,'strucneKvalifikacijeSifarnik'=>$strucneKvalifikacijeSifarnik,'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]);


    }

    public function stampaOstvareneZarade(Request $request){
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
        return view('obracunzarada::izvestaji.rekapitulacija_zarade_export_pdf',
            ['dkopData'=>$dkopData,'zaraData'=>$zaraData,'vrstePlacanjaSifarnik'=>$vrstePlacanjaSifarnik,'minimalneBrutoOsnoviceSifarnik'=>$minimalneBrutoOsnoviceSifarnik]);
    }
}
