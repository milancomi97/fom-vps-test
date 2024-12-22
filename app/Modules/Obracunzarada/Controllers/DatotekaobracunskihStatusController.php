<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusOdgovornihLicaObracunskiKoef;
use App\Modules\Obracunzarada\Consts\StatusPoenteraObracunskiKoef;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\UpdateNapomena;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class DatotekaobracunskihStatusController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficiente,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly UpdateVrstePlacanjaJson                             $updateVrstePlacanjaJson,
        private readonly UpdateNapomena                                      $updateNapomena,
        private readonly PermesecnatabelapoentRepositoryInterface            $permesecnatabelapoentInterface,
        private readonly KreirajPermisijePoenteriOdobravanja                 $kreirajPermisijePoenteriOdobravanja,
        private readonly PripremiPermisijePoenteriOdobravanja                $pripremiPermisijePoenteriOdobravanja,
    )
    {
    }

    public function permissionStatusUpdate(Request $request){
        $data = $request->all();
        $status =$this->permesecnatabelapoentInterface->updateStatus($data);
        $message='test';
        return response()->json(['message' => $message, 'status' => true], 200);

    }

    public function getPermissionStatusAdministrator(Request $request)
    {
        $data = $request->all();

        $userStatus = 0;
        $selectOptions =[];
        $permission = $this->permesecnatabelapoentInterface->getById($request->record_id);
        $userId = $data['userId'];
        $statusType = $data['statusType'];
        if ($statusType == 'odgovorna_lica_status') {
            $odogovrnaLicaData = json_decode($permission->odgovorna_lica_status, true);
            $userStatus = $odogovrnaLicaData[$userId];
            $selectOptions =  StatusOdgovornihLicaObracunskiKoef::all();

        } elseif ($statusType == 'poenteri_status') {
            $poenteriData = json_decode($permission->poenteri_status, true);
            $userStatus = $poenteriData[$userId];
            $selectOptions =  StatusPoenteraObracunskiKoef::all();
        }

        $responseData = [
            'user_status'=>$userStatus,
            'select_options'=>$selectOptions,
        ];

        return response()->json(['data' => $responseData, 'status' => true], 200);

    }

    public function updatePermissionStatusAdministrator(Request $request)
    {
        $data = $request->all();
        $status =$this->permesecnatabelapoentInterface->updateStatus($data);

        return response()->json(['data' =>$data, 'status' => true], 200);

        $test="test";

    }

    public function odobravanjeCheckPoenteri(Request $request){

        $monthId =$request->month_id;

        $data=$this->permesecnatabelapoentInterface->getAll();

        $sortByPoenterIds=[];
        foreach ($data as $organizacionaCelina){
            $poenterIds= json_decode($organizacionaCelina->poenteri_status,true);
            foreach($poenterIds as $poenterId=> $status){
                $sortByPoenterIds[$poenterId][$organizacionaCelina->organizaciona_celina_id]=$status;
                $test='test';

                if(!isset($sortByPoenterIds[$poenterId]['poenterDetails'])){
                   $poenterData =User::findOrFail($poenterId);
                    $sortByPoenterIds[$poenterId]['poenterDetails']= $poenterData->maticni_broj . ' '.$poenterData->prezime . ' '.$poenterData->ime;
                }


            }


            // TODO add poenter MATBROJ PREZIME IME
        }
//        $sortByPoenterId=
        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_odobravanje_po_statusi',['poenteriData'=>$sortByPoenterIds]);
    }



}
