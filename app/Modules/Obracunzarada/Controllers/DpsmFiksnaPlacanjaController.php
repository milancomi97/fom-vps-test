<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmAkontacijeRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
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


class DpsmFiksnaPlacanjaController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly PripremiPermisijePoenteriOdobravanja $pripremiPermisijePoenteriOdobravanja,
        private readonly VrsteplacanjaRepository $vrsteplacanjaInterface,
        private readonly DpsmFiksnaPlacanjaRepositoryInterface $dpsmFiksnaPlacanjaInteface
    )
    {
    }

    public function showFiksnap(Request $request)
    {

        $user_id = auth()->user()->id;
        $userPermission = UserPermission::where('user_id', $user_id)->first();
        $troskovnaMestaPermission = json_decode($userPermission->troskovna_mesta_poenter, true);
        $id = $request->radnik_id;
        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($id);
//        $mesecnaTabelaPoentaza->load('dpsmakontacije');
        $month_id = $mesecnaTabelaPoentaza->obracunski_koef_id;
        $monthData = $this->datotekaobracunskihkoeficijenataInterface->getById($month_id);


        $inputDate = Carbon::parse($monthData->datum);
        $formattedDate = $inputDate->format('m.Y');
//        $vrstePlacanja = $this->vrsteplacanjaInterface->getAll();
//        $vrednostAkontacije = collect(json_decode($mesecnaTabelaPoentaza->vrste_placanja,true))->where('key', '061')->first();
        $vrstePlacanja = $this->vrsteplacanjaInterface->where('DOVP_tip_vrste_placanja',false)->get();

//        $vrednostAkontacije = $mesecnaTabelaPoentaza->dpsmakontacije->iznos;

        $fiksnapData = $this->dpsmFiksnaPlacanjaInteface->where('maticni_broj',$mesecnaTabelaPoentaza->maticni_broj)->get();


        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show_fiksnap',
            [
                'monthData' => $formattedDate,
                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'vrstePlacanja' => $vrstePlacanja->toJson(),
                'vrstePlacanjaData' => json_encode($fiksnapData),
//                'vrstePlacanjaData' => $mesecnaTabelaPoentaza->vrste_placanja,
//                'vrednostAkontacije' =>$vrednostAkontacije,
                'mesecna_tabela_poentaza_id' =>$mesecnaTabelaPoentaza->id
            ]);


    }

    public function showAllFiksnap(Request $request)
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

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show_all_fiksnap',
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

    public function updateFiksnap(Request $request)
    {

//        $id = $request->mesecna_tabela_poentaza_id;
        $userMonthId = $request->record_id;
        $vrstePlacanjaData = $request->vrste_placanja;
        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($userMonthId);
        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();

        $data = [];

        if ($vrstePlacanjaData) {

                foreach ($vrstePlacanjaData as $vrstaPlacanja) {
                    if (isset($vrstaPlacanja['updateId'])) {
                        $fiksnapDataOld = $this->dpsmFiksnaPlacanjaInteface->where('id', $vrstaPlacanja['updateId'])->first();
                        $toUpdate = $fiksnapDataOld->count();

                        if ($toUpdate) {

                            $data = [
                                'sati' => $vrstaPlacanja['sati'] ?? 0,
                                'iznos' => $vrstaPlacanja['iznos'] ?? 0,
                                'procenat' => $vrstaPlacanja['procenat'] ?? 0
                            ];
                            $this->dpsmFiksnaPlacanjaInteface->update($vrstaPlacanja['updateId'], $data);

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
                            'obracunski_koef_id' => $mesecnaTabelaPoentaza->obracunski_koef_id,
                            'maticni_broj'=>$mesecnaTabelaPoentaza->maticni_broj
                        ];
                        $this->dpsmFiksnaPlacanjaInteface->create($data);
                    }
                }


        }
        return response()->json([
            'status'=>true,
            'url'=>url()->route('datotekaobracunskihkoeficijenata.show_all_fiksnap', ['month_id' => $mesecnaTabelaPoentaza->obracunski_koef_id])
        ]);
    }

//    public function updateFiksnap(Request $request)
//    {
//
////        $id = $request->mesecna_tabela_poentaza_id;
//        $userMonthId = $request->record_id;
//        $vrstePlacanjaData = $request->vrste_placanja;
//        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();
//        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($userMonthId);
//
//        $data=[];
//        $fiksnapData = $this->dpsmFiksnaPlacanjaInteface->where('user_dpsm_id',$userMonthId)->get();
//
//        if($vrstePlacanjaData){
//
//        if($fiksnapData->count()){
//            // TODO Update logic, ADD FLAG FOR ACTUAL
//            $oldData = array_column($fiksnapData->toArray(),'sifra_vrste_placanja');
//
//
//            foreach ($vrstePlacanjaData as $vrstaPlacanja){
//                $toUpdate = in_array($vrstaPlacanja['key'],$oldData);
//                if($toUpdate){
//
//                }else{
//                    $data=[
//                        'user_dpsm_id'=>(int) $userMonthId,
//                        'sifra_vrste_placanja'=>$vrstaPlacanja['key'] ?? '',
//                        'naziv_vrste_placanja'=>$sifarnikVrstePlacanja[$vrstaPlacanja['key']]['naziv_naziv_vrste_placanja'],
//                        'sati'=>$vrstaPlacanja['sati'] ?? 0,
//                        'iznos'=>$vrstaPlacanja['iznos'] ?? 0,
//                        'procenat'=>$vrstaPlacanja['procenat'] ?? 0,
//                        'user_mdr_id'=>$mesecnaTabelaPoentaza->user_mdr_id,
//                        'obracunski_koef_id'=> $mesecnaTabelaPoentaza->obracunski_koef_id
//                    ];
//                    $this->dpsmFiksnaPlacanjaInteface->create($data);
//                }
//
//
//            }
//        } else{
//            foreach ($vrstePlacanjaData as $vrstaPlacanja){
//
//                $data=[
//                    'user_dpsm_id'=>(int) $userMonthId,
//                    'sifra_vrste_placanja'=>$vrstaPlacanja['key'] ?? '',
//                    'naziv_vrste_placanja'=>$sifarnikVrstePlacanja[$vrstaPlacanja['key']]['naziv_naziv_vrste_placanja'],
//                    'sati'=>$vrstaPlacanja['sati'] ?? 0,
//                    'iznos'=>$vrstaPlacanja['iznos'] ?? 0,
//                    'user_mdr_id'=>$mesecnaTabelaPoentaza->user_mdr_id,
//                    'procenat'=>$vrstaPlacanja['procenat'] ?? 0,
//                    'obracunski_koef_id'=> $mesecnaTabelaPoentaza->obracunski_koef_id
//                ];
//
//                $this->dpsmFiksnaPlacanjaInteface->create($data);
//            }
//        }
//
//
//        }
//
//        return response()->json([
//            'status'=>true,
//            'url'=>url()->route('datotekaobracunskihkoeficijenata.show_all_fiksnap', ['month_id' => $mesecnaTabelaPoentaza->obracunski_koef_id])
//        ]);
//
//    }

    public function deleteFiksnap(Request $request)
    {
        $recordId = $request->record_id;
        // TODO UPDATE status polje INACTIVE, i da ne vide (da misle da su obrisali)
        $this->dpsmFiksnaPlacanjaInteface->delete($recordId);

        return response()->json([
            'status'=>true
        ]);
    }

}
