<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmAkontacijeRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\UpdateNapomena;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use function Psy\debug;
use PDF;


class DpsmPoentazaslogController extends Controller
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
        private readonly MaticnadatotekaradnikaRepositoryInterface           $maticnadatotekaradnikaInterface

    )
    {
    }


    public function showAll(Request $request)
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

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show_all',
            [
                'formattedDate' => $formattedDate,
                'monthData' => $monthData,
                'mesecnaTabelaPotenrazaTable' => $mesecnaTabelaPotenrazaTable,
                'mesecnaTabelaPoentazaPermissions' => $mesecnaTabelaPoentazaPermissions,
                'tableHeaders' => $tableHeaders,
                'vrstePlacanjaDescription' => $this->vrsteplacanjaInterface->getVrstePlacanjaOpis(),
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'userPermission' => $userPermission
            ]);


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
        $variabilnaData = $this->dpsmPoentazaslogInterface->where('user_dpsm_id', $id)->get();



        $dpsmData = $this->mesecnatabelapoentazaInterface->where('id', $id)->with('maticnadatotekaradnika')->get()->first();
//        $mdrData= $this->maticnadatotekaradnikaInterface->where();
        $poenterData =  $dpsmData->toArray();

        $mdrData = $dpsmData->maticnadatotekaradnika->toArray();

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show',
            [
                'monthData' => $formattedDate,
                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'vrstePlacanja' => $vrstePlacanja->toJson(),
                'vrstePlacanjaData' => $variabilnaData->toJson(),
                'mesecna_tabela_poentaza_id' =>$mesecnaTabelaPoentaza->id,
                'poenterVrstePlacanja'=>json_decode($poenterData['vrste_placanja'],true),
                'mdrData'=>$mdrData
            ]);
    }

    public function updateVariabilna(Request $request)
    {

//        $id = $request->mesecna_tabela_poentaza_id;
        $userMonthId = $request->record_id;
        $vrstePlacanjaData = $request->vrste_placanja;
        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($userMonthId);
        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();

        $data = [];
        $fiksnapData = $this->dpsmPoentazaslogInterface->where('user_dpsm_id', $userMonthId)->get();

        if ($vrstePlacanjaData) {

                foreach ($vrstePlacanjaData as $vrstaPlacanja) {
                    if (isset($vrstaPlacanja['updateId'])) {
                        $fiksnapDataOld = $this->dpsmPoentazaslogInterface->where('id', $vrstaPlacanja['updateId'])->first();
                        $toUpdate = $fiksnapDataOld->count();

                        if ($toUpdate) {

                            $data = [
                                'sati' => $vrstaPlacanja['sati'] ?? 0,
                                'iznos' => $vrstaPlacanja['iznos'] ?? 0,
                                'procenat' => $vrstaPlacanja['procenat'] ?? 0
                            ];
                            $this->dpsmPoentazaslogInterface->update($vrstaPlacanja['updateId'], $data);

                            $test = 'test';
                        }

                    } else {
                        $data = [
                            'user_dpsm_id' => (int)$userMonthId,
                            'sifra_vrste_placanja' => $vrstaPlacanja['key'] ?? '',
                            'naziv_vrste_placanja' => $sifarnikVrstePlacanja[$vrstaPlacanja['key']]['naziv_naziv_vrste_placanja'],
                            'sati' => $vrstaPlacanja['sati'] ?? 0,
                            'iznos' => $vrstaPlacanja['iznos'] ?? 0,
                            'procenat' => $vrstaPlacanja['procenat'] ?? 0,
                            'user_mdr_id' => $mesecnaTabelaPoentaza->user_mdr_id,
                            'maticni_broj' => $mesecnaTabelaPoentaza->maticni_broj,
                            'obracunski_koef_id' => $mesecnaTabelaPoentaza->obracunski_koef_id
                        ];
                        $this->dpsmPoentazaslogInterface->create($data);
                    }
                }

        }

        $this->maticnadatotekaradnikaInterface->update(
            $request->mdr_id,
            [
                'PREB_prebacaj'=>(float)$request->PREB_prebacaj,
                'DANI_kalendarski_dani'=>$request->DANI_kalendarski_dani
            ]);
        return response()->json([
            'status'=>true,
            'url'=>url()->route('datotekaobracunskihkoeficijenata.show_all', ['month_id' => $mesecnaTabelaPoentaza->obracunski_koef_id])
        ]);
    }
    public function deleteVariabilna(Request $request)
    {
        $recordId = $request->record_id;
        $this->dpsmPoentazaslogInterface->delete($recordId);

        return response()->json([
            'status'=>true
        ]);
    }

}
