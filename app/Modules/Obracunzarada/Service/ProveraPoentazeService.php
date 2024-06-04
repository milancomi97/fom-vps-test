<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;

class ProveraPoentazeService
{
    public function __construct(
        private readonly PermesecnatabelapoentRepositoryInterface $permesecnatabelapoentInterface,
        private readonly RadniciRepositoryInterface $radniciRepositoryInterface,

    )
    {
    }

    public function kalkulacijaPoRadniku($mesecnaTabelaPotenrazaTable)
    {

        return $mesecnaTabelaPotenrazaTable;
    }

    public function kalkulacijaPoTroskovnomCentru($mesecnaTabelaPotenrazaTable,$vrstePlacanjaSifarnik)
    {

        foreach ($mesecnaTabelaPotenrazaTable as $tCentarKey =>$tcentarData){
            $brojac=[];

            foreach ($tcentarData as $data){
                $brojacRadnik=0;
                foreach($data->vrste_placanja as $vrstaPlacanja) {

                    if($vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['ANOM_poentaza_provera']==5 || $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['ANOM_poentaza_provera']==3){
                        $test='test';
                        $brojacRadnik+=$vrstaPlacanja['sati'];
                    }

                    if($vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['ANOM_poentaza_provera']==1){
                        $test='test';
                        $brojacRadnik-=$vrstaPlacanja['sati'];
                    }


                    if (isset($brojac[$vrstaPlacanja['key']])) {
                        $brojac[$vrstaPlacanja['key']] += $vrstaPlacanja['sati'];
                    } else {
                        $brojac[$vrstaPlacanja['key']] = $vrstaPlacanja['sati'];
                    }
                    $test='test';

                }
                $data['rowSum']=$brojacRadnik;




                $test='test';

            }
            $tcentarData->put('columnSum',$brojac);
            $test='test';
        }

        return $mesecnaTabelaPotenrazaTable;
    }
    function addOrSum(&$array, $key, $value) {

    }

}
