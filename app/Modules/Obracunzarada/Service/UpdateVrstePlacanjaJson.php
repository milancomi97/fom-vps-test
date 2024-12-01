<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;

class UpdateVrstePlacanjaJson
{
    const UPDATEACTION =[
        0=>'bezpravila',
        1=>'umanjirad_i_obrok',
        5=>'uvecajobrok',
        2=>'umanjirad'
    ];


    public function __construct(readonly private VrsteplacanjaRepositoryInterface $vrsteplacanjaInterface)
    {
    }

    public function updateSatiByKey($radnikEvidencija, $input_key, $input_value)
    {

        $negativniBrojac = 0;
        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();

        $vrstePlacanje = json_decode($radnikEvidencija->vrste_placanja, true);
        $anomRule = $vrstePlacanjaSifarnik[$input_key]['ANOM_poentaza_provera'];

        if($input_key=='020'){
            $anomRule=2;
        }
        $anomAction = self::UPDATEACTION[$anomRule];

        $updatedVrstePlacanja = array_map(function ($placanje) use ($anomRule,$input_value,$input_key,&$negativniBrojac) {

                if($input_key==$placanje['key']){

                    $oldValue=$placanje['sati'];
                    $placanje['sati'] = (int) $input_value;
                    $inputValueInt= (int)$input_value;

                  if($anomRule >0){
                    $negativniBrojac+= $inputValueInt- $oldValue;
                  }

                }
                return $placanje;
            }, $vrstePlacanje);


            $test='test';

            if($negativniBrojac !== 0){


                $calculatedVrstePlacanja = array_map(function ($placanje) use ($anomAction,&$negativniBrojac) {

                    if($anomAction=='umanjirad_i_obrok' &&('001'==$placanje['key'] || '019'== $placanje['key'])){
                    $placanje['sati'] =  $placanje['sati']-$negativniBrojac;
                    }

                    if($anomAction=='umanjirad' && '001'==$placanje['key']){
                        $placanje['sati'] =  $placanje['sati']-$negativniBrojac;
                    }


                    if($anomAction=='uvecajobrok' && '019'==$placanje['key']){
                        $placanje['sati'] =  $placanje['sati']+$negativniBrojac;
                    }


                    return $placanje;
                }, $updatedVrstePlacanja);



//
//            foreach ($vrstePlacanje as &$placanje) {
//
//
//                if ($placanje['key'] == '001'){
//                    $placanje['sati'] =  $placanje['sati']-$negativniBrojac;
//                }
//
//                if($placanje['key'] == '019' ) {
//
//
//                    $placanje['sati'] =  $placanje['sati']-$negativniBrojac;
//                }
//
//
//            }





//                $radnikEvidencija->vrste_placanja = json_encode($calculatedVrstePlacanja);
//                $radnikEvidencija->save();
//                return ['result'=>'negativni_brojac','value'=>$negativniBrojac];
            }

        if(isset($calculatedVrstePlacanja)){
            $radnikEvidencija->vrste_placanja = json_encode($calculatedVrstePlacanja);
            $radnikEvidencija->save();
            return $calculatedVrstePlacanja;

        }else{
            $radnikEvidencija->vrste_placanja = json_encode($updatedVrstePlacanja);
            $radnikEvidencija->save();
            return $updatedVrstePlacanja;
        }

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
