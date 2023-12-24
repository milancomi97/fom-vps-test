<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;

class KreirajObracunskeKoeficiente
{
    public function __construct(
        private readonly MesecnatabelapoentazaRepositoryInterface $mesecnatabelapoentazaInterface,
        private readonly RadniciRepository $radniciInterface,
        private readonly VrsteplacanjaRepositoryInterface $vrsteplacanjaInterface,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface
    )
    {
    }

    public function execute($datotekaobracunskihkoeficijenata){

        $radnici = $this->radniciInterface->getAllActive();

        $mesecnaTabelaPoentaza =$this->mesecnatabelapoentazaInterface->getAll();
        $vrstePlacanja = $this->vrsteplacanjaInterface->getVrstePlacanjaData();
        $organizacioneCeline = $this->organizacionecelineInterface->getAll();

        $vrstePlacanjaUpdated= $this->updateVrstePlacanja($vrstePlacanja,$datotekaobracunskihkoeficijenata);
        $placanja=[];

        foreach ($radnici as $key =>$radnik){
            $data[]=[
                'organizaciona_celina_id'=>$radnik->sifra_mesta_troska_id,
                'vrste_placanja'=>json_encode($vrstePlacanjaUpdated),
                'user_id'=>$radnik->id,
                'datum'=>$datotekaobracunskihkoeficijenata->datum->format('Y-m-d'),
                'maticni_broj'=>$radnik->maticni_broj,
                'ime'=>$radnik->ime,
                'prezime'=>$radnik->prezime,
                'srednje_ime'=>$radnik->srednje_ime,
                'obracunski_koef_id'=>$datotekaobracunskihkoeficijenata->id,
                'status_poentaze'=>1
            ];
        }

        return $data;
    }

    private function updateVrstePlacanja($vrstePlacanja,$datotekaobracunskihkoeficijenata){
        $vrstePlacanjaUpdated=[];
        foreach ($vrstePlacanja as &$placanje){
            $test="testt";
            if($placanje['key']=='001' || $placanje['key']=='019'){
                $placanje['value']= $datotekaobracunskihkoeficijenata->mesecni_fond_sati;

            }
            $vrstePlacanjaUpdated[]=$placanje;
        }
        return $vrstePlacanjaUpdated;

    }

}
