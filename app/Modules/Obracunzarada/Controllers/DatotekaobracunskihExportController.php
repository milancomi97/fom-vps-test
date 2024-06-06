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
        private readonly ProveraPoentazeService $proveraPoentazeService
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

        $orgCelineData = json_decode($celineZaStampu,true);
        $orgCelineArray = !is_array($orgCelineData) ? [$orgCelineData] : $orgCelineData;

        $user_id = auth()->user()->id;
        $userPermission = UserPermission::where('user_id', $user_id)->first();
        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
//        $id = $request->month_id; // TODO OVO OBAVEZNO
        $id = '1';
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($id);

        $mesecnaTabelaPotenrazaTable = $this->mesecnatabelapoentazaInterface->groupForTable('obracunski_koef_id', $id);
        $tableHeaders = $this->mesecnatabelapoentazaInterface->getTableHeaders($mesecnaTabelaPotenrazaTable);
        $mesecnaTabelaPoentazaPermissions = $this->pripremiPermisijePoenteriOdobravanja->execute('obracunski_koef_id', $id);

        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');
        $vrstePlacanjaDescription = $this->vrsteplacanjaInterface->getVrstePlacanjaOpisPdf();

        $html = '<!DOCTYPE html>
<html lang="' . str_replace('_', '-', app()->getLocale()) . '">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

      <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header, .footer, .footer-potpis {
            background-color: #f1f1f1;
        }
        .header {
            height: 26.4mm;
            line-height: 26.4mm;
            font-size: 6.35mm;
            text-align: center;
            border-width: 0.52mm;
            border-color: #8a8af5;
            border-style: dashed;
            border-bottom-width: 0px;
        }
        .footer {
            height: auto;
            text-align: left;
            line-height: 2.6mm;
            font-size: 2.6mm;
            font-weight: 600;
            border-width: 0.5mm;
            border-color: #8a8af5;
            border-style: dashed;
            border-top-width: 0px;
            border-bottom-width: 0px;
            padding: 2.6mm 0 2.6mm 10mm;

        }



        .content {
            margin: 5.2mm;
            max-width: 261mm;
        }
        .ime_prezime{
        min-width: 61mm;
        text-align:left;
        }
        table {
            border-collapse: collapse;
            page-break-inside: avoid;
            margin-left:2px;
        }

         th {
            border:0.26mm solid #000;
            padding: 1mm;
            text-align: center;
            background-color: #f2f2f2;
        }

         td {
            border:0.26mm solid #000;
            padding: 1mm;
            text-align: center;
        }
        th {
        }
        .fieldValues {
            width: 7.8mm;
            text-align: center;
        }

        .footer-opis-code{
        text-align: left;
         border: none !important;
        }

        .footer-potpis-code{
        text-align: left;
         border: none !important;
        }

        .footer-codes-potpis{
         margin-top: 10mm;
        }

        .footer-potpis-code{
            font-size: 4mm;
            font-weight: 700;
            line-height: 10mm;
        }
    </style>
</head>
<body>';

        foreach ($mesecnaTabelaPotenrazaTable as $key => $organizacionacelina) {
            if (isset($troskovnaMestaPermission[$key]) && $troskovnaMestaPermission[$key]) {
                $html .= '<div class="content">
            <div class="header">
                Organizaciona celina: <b>' . $key . '</b> - ' . $organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta . '
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>';

                foreach ($tableHeaders as $key => $header) {
                    $imePrezimeClass = $key ==2 ? 'ime_prezime' : '';
                    $html .= '<th class"'.$imePrezimeClass.'">' . $header . '</th..>';
                }

                $html .= '</tr>
                </thead>
                <tbody>';

                foreach ($organizacionacelina as $value) {
                    $html .= '<tr>
                        <td>' . $value['maticni_broj'] . '</td>
                        <td class="ime_prezime">' . $value['ime'] . '</td>';

                    foreach ($value['vrste_placanja'] as $vrstaPlacanja) {
                        $html .= '<td class="vrsta_placanja_td"><span class="fieldValues" data-record-id="' . $value['id'] . '" min="0" disabled="disabled" class="vrsta_placanja_input" data-toggle="tooltip" data-placement="top" title="' . $vrstaPlacanja['name'] . '" data-vrsta-placanja-key="' . $vrstaPlacanja['key'] . '" >' . $vrstaPlacanja['sati'] . '</span></td>';
                    }

                    $html .= '</tr>';
                }

                $html .= '</tbody>
            </table>
            <div class="footer">
                        <div class="footer-codes">

'.$vrstePlacanjaDescription.'
            </div>
            <div class="footer-codes-potpis">
'.$this->resolvePotpisPoentaze(json_decode($organizacionacelina[0]->organizacionecelina->odgovorni_direktori_pravila,true)).'
            </div>
            </div>
        </div>';
            }
        }

        $html .= '</body>
</html>';


//        return  response($html, 200)
//            ->header('Content-Type', 'text/html');
        // Load the HTML content
        try {
//            $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
        $pdf = PDF::loadView('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf',
            [
            'mesecnaTabelaPotenrazaTable'=>$mesecnaTabelaPotenrazaTable,
            'troskovnaMestaPermission'=>$troskovnaMestaPermission,
            'tableHeaders'=>$tableHeaders,
            'vrstePlacanjaDescription'=>$vrstePlacanjaDescription,
            ]
        );
            return $pdf->download('pdf_poenteri_'.date("d.m.y").'.pdf');
//            Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        } catch (\Throwable $exception) {
//            report("Proveri Formulu:".$vrstaPlacanjaSlog['sifra_vrste_placanja']);
            report($exception);
            $updatedException = new \Exception($exception->getTraceAsString(), $exception->getCode(), $exception);
            throw $updatedException;
        }

    }


    public function odobravanjeExportPdfTest(Request $request)
    {
        $rows = [];
        for ($i=0;$i<200;$i++) {
            $rows[] = ['column1' => '0002222', 'column2' => 'Prezime SR Imeeee', 'column3' => '123', 'column4' => '123', 'column5' => '123', 'column6' => '123', 'column7' => '123', 'column8' => '123', 'column9' => '123', 'column10' => '123', 'column11' => '123', 'column12' => '123', 'column13' => '123', 'column14' => '123', 'column15' => '123', 'column16' => '123', 'column17' => '123', 'column18' => '123', 'column19' => '123', 'column20' => '123', 'column21' => '123', 'column22' => '123'];
        }
//        return view('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
//            [
//                'rows'=>$rows
//            ]);
        $pdf = PDF::loadView('pdftemplates.datotekaobracunskihkoeficijenata_odobravanje_pdf_test',
            [
                'rows'=>$rows
            ]
        )->setPaper('a4', 'portrait');

        return $pdf->download('pdf_poenteri_'.date("d.m.y").'.pdf');
//            Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
    }
    private function resolvePotpisPoentaze($data){
        $html='<div class="footer-potpis-code"> Poenter________________<br>';
        foreach ($data as $item) {
            $html .= $item.' <br>';
        }

        $html.='</div>';
        return $html;
    }

}
