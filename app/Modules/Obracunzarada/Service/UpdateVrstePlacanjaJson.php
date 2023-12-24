<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;

class UpdateVrstePlacanjaJson
{
    public function __construct()
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
}
