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

        $vrstePlacanje = json_decode($radnikEvidencija->vrste_placanja, true);

        if ($this->validateVrstePlacanja($vrstePlacanje)) {

            foreach ($vrstePlacanje as &$placanje) {
                if ($placanje['key'] == $input_key) {
                    $placanje['sati'] = (int) $input_value;
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
