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

    public function execute($obracunskiKoefId)
    {

        $mesecnaTabelaPoentazaData = $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id', $obracunskiKoefId->id)->with('organizacionecelina')->select('organizaciona_celina_id')->groupBy('organizaciona_celina_id')->get();
        $data = [];

//        organizaciona_celina_id


        foreach ($mesecnaTabelaPoentazaData as $key => $organizacionaCelina) {

            $poenteriIds = $organizacionaCelina->organizacionecelina->poenteri_ids;
            $odgovornaLicaIds = $organizacionaCelina->organizacionecelina->odgovorna_lica_ids;
            $data[] = [
                'poenteri_ids' => $poenteriIds,
                'poenteri_status' => $this->setDefaultStatus($poenteriIds),
                'odgovorna_lica_ids' => $odgovornaLicaIds,
                'odgovorna_lica_status' => $this->setDefaultStatus($odgovornaLicaIds),
                'status' => 1,
                'obracunski_koef_id' => $obracunskiKoefId->id,
                'organizaciona_celina_id' => $organizacionaCelina->organizaciona_celina_id,
                'datum' => $obracunskiKoefId->datum

            ];
        }

        return $data;
    }


    public function setDefaultStatus($ids)
    {
        $statusData = [];
        if ($ids !== null) {
            $idData = json_decode($ids, true);
            foreach($idData as $id){
                $statusData[$id]=0;
            }
        }
        return json_encode($statusData);
    }
}
