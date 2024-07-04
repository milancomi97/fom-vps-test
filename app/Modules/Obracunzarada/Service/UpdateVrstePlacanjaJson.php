<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;

class UpdateVrstePlacanjaJson
{
    public function __construct(readonly private VrsteplacanjaRepositoryInterface $vrsteplacanjaInterface)
    {
    }

    public function updateSatiByKey($radnikEvidencija, $input_key, $input_value)
    {

        $negativniBrojac = 0;
        $listOdbitnihVrstaPlacanjaNaPlatu = [
            '003',
            '009',
            '010',
            '011',
            '012',
            '013',
            '014',
            '016',
            '017',
            '018',
            '023',
            '024'
        ];

        $vrstePlacanje = json_decode($radnikEvidencija->vrste_placanja, true);

        if ($this->validateVrstePlacanja($vrstePlacanje)) {



            foreach ($vrstePlacanje as &$placanje) {
                if ($placanje['key'] == $input_key) {
                    $oldValue=$placanje['sati'];
                    $placanje['sati'] = (int) $input_value;

                    if(in_array($input_key,$listOdbitnihVrstaPlacanjaNaPlatu)){
                        $negativniBrojac+= (int)$input_value- $oldValue;
                    }

                }
            }

            //Umanji Sate

            if($negativniBrojac !== 0){

            foreach ($vrstePlacanje as &$placanje) {


                if ($placanje['key'] == '001'){
                    $placanje['sati'] =  $placanje['sati']-$negativniBrojac;
                }

                if($placanje['key'] == '019' ) {


                    $placanje['sati'] =  $placanje['sati']-$negativniBrojac;
                }


            }


                $radnikEvidencija->vrste_placanja = json_encode($vrstePlacanje);
                $radnikEvidencija->save();
                return ['result'=>'negativni_brojac','value'=>$negativniBrojac];
            }

            $result1 = array_filter($vrstePlacanje, fn($item) => $item['key'] === '001');
            $result2 = array_filter($vrstePlacanje, fn($item) => $item['key'] === '002');
            $result6 = array_filter($vrstePlacanje, fn($item) => $item['key'] === '006');



            $vrstePlacanje = array_map(function($item) use ($result2,$result1,$result6) {
                if ($item['key'] =='019') {

                    $val1=reset($result1);
                    $val2=reset($result2);
                    $val6=reset($result6);

                    $item['sati']=$val1['sati']+$val2['sati']+$val6['sati'];
                }
                return $item;
            }, $vrstePlacanje);

            $result019 = array_filter($vrstePlacanje, fn($item) => $item['key'] === '019');

            $radnikEvidencija->vrste_placanja = json_encode($vrstePlacanje);
            $radnikEvidencija->save();

            return ['result'=>'nov_podatak_topli_obrok','value'=>reset($result019)['sati']];
        }
    }

    public function validateVrstePlacanja($vrstePlacanja)
    {
        foreach ($vrstePlacanja as $placanje) {

        }
        return true;
    }

    public function updateAll($radnikEvidencija, $vrstePlacanjaData)
    {

        $currentVrstePlacanja = json_decode($radnikEvidencija->vrste_placanja, true);
        $radnikEvidencija->load('maticnadatotekaradnika');
        $newVrstePlacanja = [];
        foreach ($vrstePlacanjaData as $vrstaPlacanja) {
            $updated = false;
            foreach ($currentVrstePlacanja as &$currentVrsta) {
                if ($currentVrsta['key'] == $vrstaPlacanja['key']) {
                    $currentVrsta['sati'] = (int) $vrstaPlacanja['sati'] ?? 0;
                    $currentVrsta['iznos'] = $vrstaPlacanja['iznos'] ?? '';
                    $currentVrsta['procenat'] = $vrstaPlacanja['procenat'] ?? '';
                    $currentVrsta['BRIG_brigada'] = $vrstaPlacanja['BRIG_brigada'] ?? $radnikEvidencija->maticnadatotekaradnika->BRIG_brigada;
                    $currentVrsta['RJ_radna_jedinica'] = $vrstaPlacanja['RJ_radna_jedinica'] ?? $radnikEvidencija->maticnadatotekaradnika->RJ_radna_jedinica;
                    $updated = true;
                }
            }
            if (!$updated) {
                $vrstePlacanjaAdditional = $this->getAdditionalData($vrstaPlacanja['key']);
                $currentVrstePlacanja[$vrstaPlacanja['key']] = [
                    'key' => $vrstaPlacanja['key'],
                    'id' => $vrstePlacanjaAdditional->id,
                    'name' => $vrstePlacanjaAdditional->naziv_naziv_vrste_placanja,
                    'sati' => (int) $vrstaPlacanja['sati'] ?? 0,
                    'iznos' => $vrstaPlacanja['iznos'] ?? '',
                    'procenat' => $vrstaPlacanja['procenat'] ?? '',
                    'BRIG_brigada' => $vrstaPlacanja['BRIG_brigada'] ?? $radnikEvidencija->maticnadatotekaradnika->BRIG_brigada,
                    'RJ_radna_jedinica' => $vrstaPlacanja['RJ_radna_jedinica'] ?? $radnikEvidencija->maticnadatotekaradnika->RJ_radna_jedinica,
                ];
            }

        }

        $radnikEvidencija->vrste_placanja = json_encode($currentVrstePlacanja);
        $radnikEvidencija->save();
        return $radnikEvidencija;
    }

    private function getAdditionalData($key)
    {
        return $this->vrsteplacanjaInterface->where('rbvp_sifra_vrste_placanja', $key)->first();
    }
}
