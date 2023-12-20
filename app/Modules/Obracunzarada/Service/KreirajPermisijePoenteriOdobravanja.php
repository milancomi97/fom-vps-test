<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;

class KreirajPermisijePoenteriOdobravanja
{
    public function __construct(
        private readonly MesecnatabelapoentazaRepositoryInterface $mesecnatabelapoentazaInterface
    )
    {
    }

    public function execute($obracunskiKoefId){

        $mesecnaTabelaPoentazaData =  $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id',$obracunskiKoefId->id)->with('organizacionecelina')->select('organizaciona_celina_id')->groupBy('organizaciona_celina_id')->get();
        $data =[];

//        organizaciona_celina_id


        foreach ($mesecnaTabelaPoentazaData as $key =>$organizacionaCelina){
            $data[]=[
                'poenteri_ids'=>$organizacionaCelina->organizacionecelina->poenteri_ids,
                'odgovorna_lica_ids'=>$organizacionaCelina->organizacionecelina->odgovorna_lica_ids,
                'status'=>1,
                'obracunski_koef_id'=>$obracunskiKoefId->id,
                'organizaciona_celina_id'=>$organizacionaCelina->organizaciona_celina_id,
                'datum'=>$obracunskiKoefId->datum

            ];
        }

        return $data;
    }


}
