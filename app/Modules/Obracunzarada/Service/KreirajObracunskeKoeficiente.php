<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;

class KreirajObracunskeKoeficiente
{
    public function __construct(
        private readonly MesecnatabelapoentazaRepositoryInterface $mesecnatabelapoentazaInterface,
        private readonly RadniciRepository                        $radniciInterface,
        private readonly VrsteplacanjaRepositoryInterface         $vrsteplacanjaInterface,
        private readonly OrganizacionecelineRepositoryInterface   $organizacionecelineInterface
    )
    {
    }

    public function otvoriAktivneRadnike($datotekaobracunskihkoeficijenata)
    {

        // 1. Svi aktivni
        // 2. Dodeli
        // Dodati logiku koja radi update za vrste placanja  || Varijablina
        // Dodati logiku za akontacije
        // Optimizovati logiku sa sto manje querija i ako moze kroz jedan foreach, i da ide kroz array/kolekcija umesto Queru
        $radnici = $this->radniciInterface->getAllActive();

        $vrstePlacanja = $this->getPoenterVrstePlacanjaInitData($datotekaobracunskihkoeficijenata);

        $placanja = [];

        foreach ($radnici as $key => $radnik) {
            if (isset($radnik->maticnadatotekaradnika->id)) {

                $data[] = [
                    'organizaciona_celina_id' => $radnik->sifra_mesta_troska_id,
//                    'vrste_placanja' => $vrstePlacanja,
                    'vrste_placanja'=> $vrstePlacanja,
                    'user_id' => $radnik->id,
                    'datum' => $datotekaobracunskihkoeficijenata->datum->format('Y-m-d'),
                    'maticni_broj' => $radnik->maticni_broj,
                    'ime' => $radnik->ime,
                    'prezime' => $radnik->prezime,
                    'srednje_ime' => $radnik->srednje_ime,
                    'obracunski_koef_id' => $datotekaobracunskihkoeficijenata->id,
                    'status_poentaze' => 1,
                    'user_mdr_id' => $radnik->maticnadatotekaradnika->id
                ];
            }
        }

        return $data;
    }

    private function updateVrstePlacanja($vrstePlacanja, $datotekaobracunskihkoeficijenata)
    {
        $vrstePlacanjaUpdated = [];
        foreach ($vrstePlacanja as $placanje) {

            if ($placanje['key'] == '001' || $placanje['key'] == '019') {
                $placanje['sati'] = (int) $datotekaobracunskihkoeficijenata->mesecni_fond_sati;
                $placanje['iznos'] ='';
                $placanje['procenat'] ='';
                $placanje['RJ_radna_jedinica'] ='';
                $placanje['BRIG_brigada'] ='';
            }

            $vrstePlacanjaUpdated[] = $placanje;
        }

        return $vrstePlacanjaUpdated;

    }

    private function addAkontacijaInitial($vrstePlacanjaUpdated, $datotekaobracunskihkoeficijenata)
    {

        $akontacijaVrstaPlacanja = $this->vrsteplacanjaInterface->where('rbvp_sifra_vrste_placanja', '061')->first();
        $vrstePlacanjaUpdated[] = [
            'key' => '061',
            'sati' => 0,
            'id' => $akontacijaVrstaPlacanja->id,
            'name'=> strtolower(str_replace(' ', '_', $akontacijaVrstaPlacanja->naziv_naziv_vrste_placanja)),
            'iznos'=>(int) $datotekaobracunskihkoeficijenata->vrednost_akontacije,
            'procenat'=>'',
            'RJ_radna_jedinica'=>'',
            'BRIG_brigada'=>''
        ];

        return $vrstePlacanjaUpdated;

    }

    private function updateRadnaJedinicaBrigada($vrstePlacanja,$radnik)
    {
        //
        $vrstePlacanjaUpdated = [];
        foreach ($vrstePlacanja as $placanje) {
            $placanje['RJ_radna_jedinica'] = $radnik->maticnadatotekaradnika->RJ_radna_jedinica;
            $placanje['BRIG_brigada'] = $radnik->maticnadatotekaradnika->BRIG_brigada;
            $vrstePlacanjaUpdated[] = $placanje;
        }

        return json_encode($vrstePlacanjaUpdated);
    }

    public function getPoenterVrstePlacanjaInitData($datotekaobracunskihkoeficijenata){
        $data = $this->vrsteplacanjaInterface->getAll()->sortBy('redosled_poentaza_zaglavlje');
        // Prvo sortiraj pa onda kada dodjes do 19, prestani
        // Treba da bude 19

        $fondSati = $datotekaobracunskihkoeficijenata->mesecni_fond_sati;
        $filteredData =$data->map(function ($item) use ($fondSati) {

            $newValue = strtolower(str_replace(' ', '_',  $item['naziv_naziv_vrste_placanja']));
            $mesecniFondSati = 0;

            if($item['rbvp_sifra_vrste_placanja'] == '001' || $item['rbvp_sifra_vrste_placanja'] =='019' || $item['rbvp_sifra_vrste_placanja'] =='003'){
                // Uslovi za otvaranje radnika varijabilna vrste placanja poenterska
                $mesecniFondSati = (int) $fondSati;
            }

            // Otvaranje praznih Vrsta placanja
            return $item['id'] =[
                'key'=> $item['rbvp_sifra_vrste_placanja'],
                'name' => $newValue,
                'sati'=>$mesecniFondSati,
                'id'=>$item['id'],
                'iznos'=>'',
                'procenat'=>'',
                'RJ_radna_jedinica'=>'',
                'BRIG_brigada'=>'',
                'redosled_poentaza_zaglavlje' =>$item['redosled_poentaza_zaglavlje']
            ];
        });
        return $filteredData->take(19);
    }


    public function dodeliPocetnaPoenterPlacanja($idsRadnika,$mesecniFondSati,$mesecId){

        $data = [];
        foreach ($idsRadnika as $radnik){
            $data[]=[
                'user_dpsm_id' =>$radnik->id,
                'sati'=>$mesecniFondSati,
                'maticni_broj'=>$radnik->maticni_broj,
                'sifra_vrste_placanja'=>'001',
                'obracunski_koef_id'=>$mesecId
            ];
            $data[]=[
                'user_dpsm_id' =>$radnik->id,
                'sati'=>$mesecniFondSati,
                'maticni_broj'=>$radnik->maticni_broj,
                'sifra_vrste_placanja'=>'019',
                'obracunski_koef_id'=>$mesecId
            ];
        }
        return $data;

    }

    public function dodeliPocetneAkontacijePlacanja($idsRadnika,$vrednostAkontacije,$mesecId){

        $data = [];
        foreach ($idsRadnika as $radnik){
            $data[]=[
                'user_dpsm_id' =>$radnik->id,
                'iznos' =>$vrednostAkontacije,
                'maticni_broj'=>$radnik->maticni_broj,
                'sifra_vrste_placanja'=>'019',
                'obracunski_koef_id'=>$mesecId

            ];
        }
        return $data;
    }
}
