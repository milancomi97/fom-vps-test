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

    public function execute($radnikEvidencija, $input_key, $input_value)
    {

        $vrstePlacanje = json_decode($radnikEvidencija->vrste_placanja, true);

        if ($this->validateVrstePlacanja($vrstePlacanje)) {

            foreach ($vrstePlacanje as &$placanje) {
                if ($placanje['key'] == $input_key) {
                    $placanje['value'] = $input_value;
                }
            }
            $radnikEvidencija->vrste_placanja = json_encode($vrstePlacanje);
            return $radnikEvidencija->save();
        }
    }

    public function validateVrstePlacanja($vrstePlacanja)
    {
        foreach ($vrstePlacanja as $placanje) {
        }
        return true;
    }

    public  function executeAll($radnikEvidencija,$vrstePlacanjaData){

        $currentVrstePlacanja = json_decode($radnikEvidencija->vrste_placanja,true);

        $newVrstePlacanja = [];
        foreach ($vrstePlacanjaData as $vrstaPlacanja){
            $updated=false;
            foreach ($currentVrstePlacanja as $currentVrsta){
                if($currentVrsta['key'] == $vrstaPlacanja['key']){
                    $currentVrsta['value'] = $vrstaPlacanja['value'];
                    $updated=true;
                }
                array_push($newVrstePlacanja,$currentVrsta);
            }
            if(!$updated){
                $vrstePlacanjaAdditional = $this->getAdditionalData($vrstaPlacanja['key']);
                $newVrstePlacanja[$vrstaPlacanja['key']] =[
                    'value' => $vrstaPlacanja['value'],
                    'key'=>$vrstaPlacanja['key'],
                    'id'=>$vrstePlacanjaAdditional->id,
                    'name'=>$vrstePlacanjaAdditional->naziv_naziv_vrste_placanja
                ];
            }

        }

        $radnikEvidencija->vrste_placanja = json_encode($newVrstePlacanja);
        $radnikEvidencija->save();
        return $radnikEvidencija;
    }

    private function getAdditionalData($key){
        return $this->vrsteplacanjaInterface->where('rbvp_sifra_vrste_placanja',$key)->first();
    }
}
