<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\KreditoriRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;

class ObradaObracunavanjeService
{

    public function __construct(
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface $dkopSveVrstePlacanjaInterface,
        private readonly IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly RadnamestaRepositoryInterface $radnamestaInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface,
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface,
        private readonly KreditoriRepositoryInterface $kreditoriInterface

    )
    {
    }

    public function pripremaPodataka($id)
    {

        $data = $this->dkopSveVrstePlacanjaInterface->where('obracunski_koef_id', $id)->get()->groupBy('user_dpsm_id');


        return [];
    }


    public function pripremaPodatakaRadnik($monthId,$radnikMaticniId) // Radnik napravi logiku za sve ostale radnike
    {

        $radnikData = [];
        $data = $this->dkopSveVrstePlacanjaInterface->where('maticni_broj', $radnikMaticniId)->where('obracunski_koef_id', $monthId)->with('maticnadatotekaradnika')->get()->sortBy('sifra_vrste_placanja');

        foreach ($data as $radnik) {



            if($radnik['sifra_vrste_placanja']=='093'){
//                ;
                $kreditData = $this->dpsmKreditiInterface->getById($radnik['kredit_glavna_tabela_id']);
                $kreditorData = $this->kreditoriInterface->where('sifk_sifra_kreditora',$kreditData->SIFK_sifra_kreditora)->get()->first();

                $radnik['kreditAdditionalData']=$kreditData->toArray();
                $radnik['kreditorAdditionalData']=$kreditorData->toArray();

            }
            $radnikData[]= $radnik;
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
