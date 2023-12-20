<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;

class PripremiPermisijePoenteriOdobravanja
{
    public function __construct(
        private readonly PermesecnatabelapoentRepositoryInterface $permesecnatabelapoentInterface,
        private readonly RadniciRepositoryInterface $radniciRepositoryInterface,

    )
    {
    }

    public function execute($obracunski_koef_id, $id)
    {
        $data = $this->permesecnatabelapoentInterface->where($obracunski_koef_id,$id)->get();


        $mesecnaTabelaPoentazaPermissions= [];
        foreach ($data as $permission){
            $key = $permission['organizaciona_celina_id'];
            $poenterData= $this->resolveJsonFields($permission['poenteri_ids'],$permission['poenteri_status']);
            $odgovornaLicaData= $this->resolveJsonFields($permission['odgovorna_lica_ids'],$permission['odgovorna_lica_status']);
                $mesecnaTabelaPoentazaPermissions[$key]=[
                    'permission_record_id'=>$permission->id,
                    'poenterData'=>$poenterData,
                    'odgovornaLicaData'=>$odgovornaLicaData
                ];

        }
        return $mesecnaTabelaPoentazaPermissions;
    }

    private function resolveJsonFields($users,$statuses){

        $usersData = [];
        if($users!==null){
        if($statuses == null){
            $userIds = json_decode($users);
            foreach ($userIds as $userId){
                $user = $this->radniciRepositoryInterface->getById($userId);
                $usersData[$userId] = [
                    'status'=>0,
                    'name' => $user->prezime . ' ' . $user->ime
                ];
            }
        }else{
            $userIds = json_decode($users);
            $status = json_decode($statuses,true);
            foreach ($userIds as $userId){
                $user = $this->radniciRepositoryInterface->getById($userId);

                $usersData[$userId] = [
                    'status'=>$status[$userId] ?? 0,
                    'name' => $user->prezime . ' ' . $user->ime
                ];
            }
            // TODO
            $test="test";
//            $usersData[$userId]= $statuses;
        }

        }

        return $usersData;
    }

}
