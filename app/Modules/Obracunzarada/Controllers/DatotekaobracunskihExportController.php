<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Exports\PoenterUnosExport;
use App\Http\Controllers\Controller;
use App\Models\Datotekaobracunskihkoeficijenata;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmAkontacijeRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
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
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficienteService,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly UpdateVrstePlacanjaJson                             $updateVrstePlacanjaJson,
        private readonly UpdateNapomena                                      $updateNapomena,
        private readonly PermesecnatabelapoentRepositoryInterface            $permesecnatabelapoentInterface,
        private readonly KreirajPermisijePoenteriOdobravanja                 $kreirajPermisijePoenteriOdobravanja,
        private readonly PripremiPermisijePoenteriOdobravanja                $pripremiPermisijePoenteriOdobravanja,
        private readonly VrsteplacanjaRepository                             $vrsteplacanjaInterface,
        private readonly DpsmPoentazaslogRepositoryInterface                 $dpsmPoentazaslogInterface,
        private readonly DpsmAkontacijeRepositoryInterface                   $dpsmAkontacijeInterface,
        private readonly MesecValidationService                               $mesecValidationService,
        private readonly ProveraPoentazeService $proveraPoentazeService,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface
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
        $test='test';

    }

    public function stampaOstvareneZarade(Request $request){

        $test='test';
    }

    public function stampaRangListe(Request $request){
        $test='test';

    }
}
