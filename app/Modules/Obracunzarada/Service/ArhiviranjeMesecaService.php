<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaDarhObradaSveDkopRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaMaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaSumeZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use Illuminate\Support\Carbon;

class ArhiviranjeMesecaService
{

    public function __construct(
        private readonly IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly RadnamestaRepositoryInterface $radnamestaInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface,
        private readonly ArhivaDarhObradaSveDkopRepositoryInterface $arhivaDarhObradaSveDkopInterface,
        private readonly ArhivaMaticnadatotekaradnikaRepositoryInterface $arhivaMaticnadatotekaradnikaInterface,
        private readonly ArhivaSumeZaraPoRadnikuRepositoryInterface $arhivaSumeZaraPoRadnikuInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,


    )
    {
    }


    public function getDataByMonthId($monthId){


        return [];
    }

    public function archiveMDR($mdrData,$datum){
//        $mdrArray=$mdrData->toArray();

        $updatedMdr = $mdrData->map(function ($mdr)  use($datum) {

            unset($mdr->id);
            unset($mdr->updated_at);
            unset($mdr->created_at);

            $mdr['M_G_mesec_godina']=$datum->format('my');
            $mdr['M_G_date']=$datum;

            return $mdr;
        });
        $result =$this->arhivaMaticnadatotekaradnikaInterface->createMany($updatedMdr->toArray());

        $oldData =$this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan',1)->get();

        $updatedMdr = $oldData->map(function ($mdr) {
            $mdr->update(['PREB_prebacaj'=>1.0]);

            return $mdr;

        });
            return $result;
    }





    public function archiveDkop($dkopData,$datum){
//        $mdrArray=$mdrData->toArray();

//        $startOfMonth = Carbon::createFromFormat('m.Y', $mgString)->startOfMonth();
//        $mgDate = $datum->format('Y-m-d');

        $dkopUpdated = $dkopData->map(function ($dkop) use($datum) {
            unset($dkop->id);
            unset($dkop->obracunski_koef_id);
            unset($dkop->tip_unosa);
            unset($dkop->user_dpsm_id);
            unset($dkop->user_mdr_id);
            unset($dkop->updated_at);
            unset($dkop->created_at);

            $dkop['M_G_mesec_godina']=$datum->format('my');
            $dkop['M_G_date']=$datum;



//            $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();
//            $startDate = $startOfMonth->format('Y-m-d');
//            $arhivaMdr = $this->arhivaMaticnadatotekaradnikaInterface->where('M_G_date', $startDate)->where('MBRD_maticni_broj', $maticniBroj)->get();





            return $dkop;
        });

        $dkopChunksData = $dkopUpdated->chunk(500);


        foreach ($dkopChunksData as $dkopChunk){
            $this->arhivaDarhObradaSveDkopInterface->createMany($dkopChunk->toArray());
        }
        return [];
    }


    public function archiveZara($zaraData,$datum){
//        $mdrArray=$mdrData->toArray();

        $updatedZara = $zaraData->map(function ($zara) use($datum) {
            unset($zara->id);
            unset($zara->updated_at);
            unset($zara->created_at);

            $zara['M_G_mesec_godina']=$datum->format('my');
            $zara['M_G_date']=$datum;
            return $zara;
        });

        $result =$this->arhivaSumeZaraPoRadnikuInterface->createMany($updatedZara->toArray());
        return $result;
    }





    public function resolveKrediti($dpsmKrediti,$kreditiPomocni){

        $allData = [];


        foreach ($dpsmKrediti as $glavniKredit){
            foreach ($kreditiPomocni as $pomocniKredit){
                $test='test';


            }
        }

        return $allData;
}

}
