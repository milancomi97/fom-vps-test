<?php

namespace App\Modules\Obracunzarada\Service;

use App\Models\Datotekaobracunskihkoeficijenata;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;

class MesecValidationService
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,


    )
    {
    }

    public function checkMonthStatus($monthId){

        $test='';
        return $this->datotekaobracunskihkoeficijenataInterface->where('status', Datotekaobracunskihkoeficijenata::AKTUELAN)->count();
    }


}
