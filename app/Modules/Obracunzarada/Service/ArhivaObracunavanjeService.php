<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaDarhObradaSveDkopRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;

class ArhivaObracunavanjeService
{

    public function __construct(
        private readonly IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly RadnamestaRepositoryInterface $radnamestaInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface,
        private readonly ArhivaDarhObradaSveDkopRepositoryInterface $arhivaDarhObradaSveDkopInterface,
    )
    {
    }



    public function pripremaPodatakaRadnik($startDate,$maticniBroj)
    {
       return  $this->arhivaDarhObradaSveDkopInterface->where('M_G_date', $startDate)->where('maticni_broj',$maticniBroj)->get();

        return [];
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
