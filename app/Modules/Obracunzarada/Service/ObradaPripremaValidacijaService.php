<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;

class ObradaPripremaValidacijaService
{
    public function __construct(
        private readonly ObradaFormuleService                          $obradaFormuleService,
        private readonly ObradaZaraPoRadnikuRepositoryInterface        $obradaZaraPoRadnikuInterface,
        private readonly DpsmKreditiRepositoryInterface                $dpsmKreditiInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface $dkopSveVrstePlacanjaInterface,
        private readonly \App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface $obradaKreditiInterface
    )
    {
    }


    public function checkMinimalneBrutoOsnovice($data){
      if($data == null){
          return "Popunite minimalne bruto osnovice tabelu pre obrade.";
      }
      return false;
    }

    public function checkIsDataUpdated($data){

        return true;
    }
}
