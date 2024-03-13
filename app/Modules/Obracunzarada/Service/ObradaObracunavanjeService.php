<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;

class ObradaObracunavanjeService
{

    public function __construct(
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface $dkopSveVrstePlacanjaInterface,
        private readonly IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly RadnamestaRepositoryInterface $radnamestaInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface

    )
    {
    }

    public function pripremaPodataka($id)
    {

        $data = $this->dkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $id)->get()->groupBy('user_dpsm_id');


        return [];
    }


    public function pripremaPodatakaRadnik($id) // Radnik napravi logiku za sve ostale radnike
    {
//        $testMaticni = '0005399';

        $testMaticni = '0004908';

//        0005399
//        0005399
//0004021
//0004202
//0004337
//0004770
//0004870
//0004908
//0005091
        $radnikData = [];
        $data = $this->dkopSveVrstePlacanjaInterface->where('maticni_broj', $testMaticni)->where('obracunski_koef_id', $id)->with('maticnadatotekaradnika')->get()->groupBy('user_dpsm_id');

        foreach ($data as $radnik) {

            $radnikData = $radnik;
        }

        return $radnikData;
    }

    public function pripremaMdrPodatakaRadnik($mdrData)
    {
        $dataSifarnik = $this->getSifarnikData();

//        $result = $mdrData->map(function ($item, $key) use ($dataSifarnik) {
//            if ($key == 'RBPS_priznata_strucna_sprema') {
//                return $dataSifarnik['priznata_ss'][$item]['naziv_kvalifikacije'];
//            } else if ($key == 'RBIM_isplatno_mesto_id') {
//                return $dataSifarnik['isplatno_mesto'][$item]['naim_naziv_isplatnog_mesta'];
//            } else if ($key == 'RBRM_radno_mesto') {
//                return $dataSifarnik['radno_mesto'][$item]['narm_naziv_radnog_mesta'];
//            } else {
//                return $item;
//            }
//        });
//
//        return $result;
        $result = $mdrData->map(function ($item, $key) use ($dataSifarnik) {
            switch ($key) {
                case 'RBPS_priznata_strucna_sprema':
                    return $dataSifarnik['priznata_ss'][$item]['naziv_kvalifikacije'] ?? $item;
                case 'RBIM_isplatno_mesto_id':
                    return $dataSifarnik['isplatno_mesto'][$item]['naim_naziv_isplatnog_mesta'] ?? $item;
                case 'RBRM_radno_mesto':
                    return $dataSifarnik['radno_mesto'][$item]['narm_naziv_radnog_mesta'] ?? $item;
                default:
                    return $item;
            }
        });

        return $result;
    }


    public function getSifarnikData(){

        $priznataStrucnaSpremaData=$this->strucnakvalifikacijaInterface->getAll()->groupBy('sifra_kvalifikacije')->map(function ($group) {
            return $group->first();
        });

        // 930
        $isplatnaMestaData=$this->isplatnamestaInterface->getAll()->groupBy('rbim_sifra_isplatnog_mesta')->map(function ($group) {
            return $group->first();
        });


        $radnaMestaData=$this->radnamestaInterface->getAll()->groupBy('rbrm_sifra_radnog_mesta')->map(function ($group) {
            return $group->first();
        });


        return[
            'priznata_ss'=>$priznataStrucnaSpremaData,
            'isplatno_mesto'=>$isplatnaMestaData,
            'radno_mesto'=>$radnaMestaData
        ];

    }

}
