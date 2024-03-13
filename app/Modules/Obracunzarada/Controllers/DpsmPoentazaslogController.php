<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
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
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Obracunzarada\Service\UpdateNapomena;
use App\Modules\Obracunzarada\Service\UpdateVrstePlacanjaJson;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use function Psy\debug;


class DpsmPoentazaslogController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficienteService,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly UpdateVrstePlacanjaJson                             $updateVrstePlacanjaJson,
        private readonly UpdateNapomena                                      $updateNapomena,
        private readonly PermesecnatabelapoentRepositoryInterface            $permesecnatabelapoentInterface,
        private readonly KreirajPermisijePoenteriOdobravanja $kreirajPermisijePoenteriOdobravanja,
        private readonly PripremiPermisijePoenteriOdobravanja $pripremiPermisijePoenteriOdobravanja,
        private readonly VrsteplacanjaRepository $vrsteplacanjaInterface,
        private readonly DpsmPoentazaslogRepositoryInterface $dpsmPoentazaslogInterface,
        private readonly DpsmAkontacijeRepositoryInterface $dpsmAkontacijeInterface
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
        $vrstePlacanja = $this->vrsteplacanjaInterface->where('DOVP_tip_vrste_placanja',true)->get();

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show',
            [
                'monthData' => $formattedDate,
                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'vrstePlacanja' => $vrstePlacanja->toJson(),
                'vrstePlacanjaData' => $mesecnaTabelaPoentaza->vrste_placanja
            ]);
    }


        public function updateAll(Request $request)
    {
        // Logika za varijabilne vrste placanja
        $vrstePlacanjaData = $request->vrste_placanja;
        $record_id =$request->record_id;
        $radnikEvidencija = $this->mesecnatabelapoentazaInterface->getById($record_id);
        $status = $this->updateVrstePlacanjaJson->updateAll($radnikEvidencija,$vrstePlacanjaData);

        if($status){
            $message='uspesno promenjen';
            return response()->json(['message' => $message, 'status' => true], 200);

        }
        $message='greska';
        return response()->json(['message' => $message, 'status' => false], 200);
    }


    public function updateVarijabilna(Request $request)
    {
        // Logika za varijabilne vrste placanja
        $vrstePlacanjaData = $request->vrste_placanja;
        $record_id =$request->record_id;
        $radnikEvidencija = $this->mesecnatabelapoentazaInterface->getById($record_id);
        $status = $this->updateVrstePlacanjaJson->updateAll($radnikEvidencija,$vrstePlacanjaData);

        if($status){
            $message='uspesno promenjen';
            return response()->json(['message' => $message, 'status' => true], 200);

        }
        $message='greska';
        return response()->json(['message' => $message, 'status' => false], 200);
    }
}
