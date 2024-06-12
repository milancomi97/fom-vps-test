<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmAkontacijeRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\KreditoriRepositoryInterface;
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


class DpsmKreditiController extends Controller
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly PripremiPermisijePoenteriOdobravanja $pripremiPermisijePoenteriOdobravanja,
        private readonly VrsteplacanjaRepository $vrsteplacanjaInterface,
        private readonly KreditoriRepositoryInterface $kreditoriInteface,
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface
    )
    {
    }

    public function showAllKrediti(Request $request)
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

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show_all_krediti',
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

    public function showKrediti(Request $request)
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

        $kreditoriList = $this->kreditoriInteface->getAll();
//        sifk_sifra_kreditora imek_naziv_kreditora

        $kreditiData = $this->dpsmKreditiInterface->where('user_dpsm_id',$id)->get();

        return view('obracunzarada::datotekaobracunskihkoeficijenata.datotekaobracunskihkoeficijenata_show_krediti',
            [
                'monthData' => $formattedDate,
                'mesecnaTabelaPoentaza' => $mesecnaTabelaPoentaza,
                'troskovnaMestaPermission' => $troskovnaMestaPermission,
                'statusRadnikaOK' => StatusRadnikaObracunskiKoef::all(),
                'listaKreditora' => $kreditoriList->toJson(),
                'listaKreditoraData' => json_encode($kreditiData),
//                'vrstePlacanjaData' => $mesecnaTabelaPoentaza->vrste_placanja,
//                'vrednostAkontacije' =>$vrednostAkontacije,
                'mesecna_tabela_poentaza_id' =>$mesecnaTabelaPoentaza->id
            ]);


    }
    public function deleteKrediti(Request $request){
        $recordId = $request->record_id;
        $this->dpsmKreditiInterface->delete($recordId);

        return response()->json([
            'status'=>true
        ]);
    }

    public function updateKrediti(Request $request)
    {

//        $id = $request->mesecna_tabela_poentaza_id;
        $userMonthId = $request->record_id;
        $vrstePlacanjaData = $request->vrste_placanja;
        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($userMonthId);

        $data=[];
        $kreditiData = $this->dpsmKreditiInterface->where('user_dpsm_id',$userMonthId)->get();

        if($vrstePlacanjaData){

//            ["","partija","glavnica","saldo","rata","datum_zaduzenja",""]

                foreach ($vrstePlacanjaData as $vrstaPlacanja){

                    if (isset($vrstaPlacanja['updateId'])) {
                        $kreditiDataOld = $this->dpsmKreditiInterface->where('id', $vrstaPlacanja['updateId'])->first();
                        $toUpdate = $kreditiDataOld->count();


                    if($toUpdate) {
                        $data = [
//                            'sati' => $vrstaPlacanja['sati'] ?? 0,
//                            'iznos' => $vrstaPlacanja['iznos'] ?? 0,
//                            'procenat' => $vrstaPlacanja['procenat'] ?? 0,
                            'SIFK_sifra_kreditora'=>$vrstaPlacanja['key'] ?? '',
                            'IMEK_naziv_kreditora'=>$vrstaPlacanja['naziv'] ?? '',
                            'GLAVN_glavnica'=>$vrstaPlacanja['glavnica'] ?? '',
                            'SALD_saldo'=>$vrstaPlacanja['saldo'] ?? '',
                            'RATA_rata'=>$vrstaPlacanja['rata'] ?? '',
                            'PART_partija_poziv_na_broj'=>$vrstaPlacanja['partija'] ?? '',
                            'maticni_broj'=>$mesecnaTabelaPoentaza['maticni_broj'],
                            'POCE_pocetak_zaduzenja'=>$vrstaPlacanja['pocetak_zaduzenja']=="true",
                        ];
                        $this->dpsmKreditiInterface->update($vrstaPlacanja['updateId'], $data);

                    }
                    }else{
                        $data=[
                            'user_dpsm_id'=>(int) $userMonthId,
                            'obracunski_koef_id'=> $mesecnaTabelaPoentaza->obracunski_koef_id,
                            'SIFK_sifra_kreditora'=>$vrstaPlacanja['key'] ?? '',
                            'IMEK_naziv_kreditora'=>$vrstaPlacanja['naziv'] ?? '',
                            'GLAVN_glavnica'=>$vrstaPlacanja['glavnica'] ?? '',
                            'SALD_saldo'=>$vrstaPlacanja['saldo'] ?? '',
                            'RATA_rata'=>$vrstaPlacanja['rata'] ?? '',
                            'PART_partija_poziv_na_broj'=>$vrstaPlacanja['partija'] ?? '',
                            'maticni_broj'=>$mesecnaTabelaPoentaza['maticni_broj'],
                            'user_mdr_id'=>$mesecnaTabelaPoentaza->id,
                            'POCE_pocetak_zaduzenja'=>true,
//                            'DATUM_zaduzenja'=>$vrstaPlacanja['datum_zaduzenja'] ?? 0,
                        ];
                        $this->dpsmKreditiInterface->create($data);
                    }
                }
            }

            // DODAJ user_dpsm_id kod Fiksnih placanja
            // do foreach
            // do Load, save or update
            // Ucitaj podatke o vrstama placanja

        return response()->json([
            'status'=>true,
            'url'=>url()->route('datotekaobracunskihkoeficijenata.show_all_krediti', ['month_id' => $mesecnaTabelaPoentaza->obracunski_koef_id])
        ]);

    }

//    public function updateKrediti2(Request $request)
//    {
//
////        $id = $request->mesecna_tabela_poentaza_id;
//        $userMonthId = $request->record_id;
//        $vrstePlacanjaData = $request->vrste_placanja;
//        $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->getById($userMonthId);
//
//        $data=[];
//        $kreditiData = $this->dpsmKreditiInterface->where('user_dpsm_id',$userMonthId)->get();
//
//        if($vrstePlacanjaData){
//
////            ["","partija","glavnica","saldo","rata","datum_zaduzenja",""]
//
//            if($kreditiData->count()){
//                // TODO Update logic, ADD FLAG FOR ACTUAL
//                $oldData = array_column($kreditiData->toArray(),'sifra_vrste_placanja');
//                foreach ($vrstePlacanjaData as $vrstaPlacanja){
//                    $toUpdate = in_array($vrstaPlacanja['key'],$oldData);
//                    if($toUpdate){
//
//                    }else{
//                        $data=[
//                            'user_dpsm_id'=>(int) $userMonthId,
//                            'obracunski_koef_id'=> $mesecnaTabelaPoentaza->obracunski_koef_id,
//                            'SIFK_sifra_kreditora'=>$vrstaPlacanja['key'] ?? '',
//                            'IMEK_naziv_kreditora'=>$vrstaPlacanja['naziv'] ?? '',
//                            'GLAVN_glavnica'=>$vrstaPlacanja['glavnica'] ?? '',
//                            'SALD_saldo'=>$vrstaPlacanja['saldo'] ?? '',
//                            'RATA_rata'=>$vrstaPlacanja['rata'] ?? '',
//                            'PART_partija_poziv_na_broj'=>$vrstaPlacanja['rata'] ?? ''
////                            'POCE_pocetak_zaduzenja'=>$vrstaPlacanja['pocetak_zaduzenja'] ?? 0,
////                            'DATUM_zaduzenja'=>$vrstaPlacanja['datum_zaduzenja'] ?? 0,
//
//                        ];
//                        $this->dpsmKreditiInterface->create($data);
//                    }
//
//
//                }
//            } else{
//                foreach ($vrstePlacanjaData as $vrstaPlacanja){
//
//                    $data=[
//                        'user_dpsm_id'=>(int) $userMonthId,
//                        'obracunski_koef_id'=> $mesecnaTabelaPoentaza->obracunski_koef_id,
//                        'SIFK_sifra_kreditora'=>$vrstaPlacanja['key'] ?? '',
//                        'IMEK_naziv_kreditora'=>$vrstaPlacanja['naziv'] ?? '',
//                        'GLAVN_glavnica'=>$vrstaPlacanja['glavnica'] ?? '',
//                        'SALD_saldo'=>$vrstaPlacanja['saldo'] ?? '',
//                        'RATA_rata'=>$vrstaPlacanja['rata'] ?? '',
//                        'PART_partija_poziv_na_broj'=>$vrstaPlacanja['partija'] ?? ''
////                            'POCE_pocetak_zaduzenja'=>$vrstaPlacanja['pocetak_zaduzenja'] ?? 0,
////                            'DATUM_zaduzenja'=>$vrstaPlacanja['datum_zaduzenja'] ?? 0,
//
//                    ];
//
//                    $this->dpsmKreditiInterface->create($data);
//                }
//            }
//
//            // DODAJ user_dpsm_id kod Fiksnih placanja
//            // do foreach
//            // do Load, save or update
//            // Ucitaj podatke o vrstama placanja
//
//
//        }
//
//        return response()->json([
//            'status'=>true,
//            'url'=>url()->route('datotekaobracunskihkoeficijenata.show_all_krediti', ['month_id' => $mesecnaTabelaPoentaza->obracunski_koef_id])
//        ]);
//
//    }

}
