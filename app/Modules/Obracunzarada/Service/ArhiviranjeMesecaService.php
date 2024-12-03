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
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;

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
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface


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
            unset($mdr->email_za_plate);
            unset($mdr->email_za_plate_poslat);

            $mdr['M_G_mesec_godina']=$datum->format('my');
            $mdr['M_G_date']=$datum;

            return $mdr;
        });
        $result =$this->arhivaMaticnadatotekaradnikaInterface->createMany($updatedMdr->toArray());

        $oldData =$this->maticnadatotekaradnikaInterface->where('ACTIVE_aktivan',1)->get();

        $updatedMdr = $oldData->map(function ($mdr) {

            $newDate = $this->resolveDateStaz($mdr);

            $mdr->update(['PREB_prebacaj'=>1.0,'GGST_godine_staza'=>$newDate['godine'],'MMST_meseci_staza'=>$newDate['meseci']]);



            return $mdr;

        });
            return $result;
    }



        public function resolveDateStaz($mdr){


        $godine = (int)$mdr->GGST_godine_staza;
            $meseci = (int)$mdr->MMST_meseci_staza;

            if($meseci ==11){
                $godine =$godine+1;
                $meseci= 0 ;
            } else{
                $meseci = $meseci+1;
            }

            return ['godine'=>$godine,'meseci'=>$meseci];
                $test='test';



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
            unset($dkop->kredit_glavna_tabela_id);

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
            unset($zara->user_dpsm_id);
            unset($zara->obracunski_koef_id);
            unset($zara->user_mdr_id);



            $zara['M_G_mesec_godina']=$datum->format('my');
            $zara['M_G_date']=$datum;
            return $zara;
        });

        $result =$this->arhivaSumeZaraPoRadnikuInterface->createMany($updatedZara->toArray());
        return $result;
    }





    public function resolveKrediti($dpsmKrediti,$kreditiPomocni){

        $allData = [];





///
///
///
///                 } else if ($neto2 - $siobkr <= 0 && $kredit->SALD_saldo > 0) {
////                        id =58

//        foreach ($dpsmKrediti as $glavniKredit){



///
///
//    } else if ($neto2 > 0 && $kredit->SALD_saldo > 0) {
//    // id = 582

        //        if (($neto2 - $siobkr - $kredit->RATA_rata -$kredit->RATB) > 0 && $kredit->SALD_saldo-$kredit->RATB > 0) {
////                        id=222
            foreach ($kreditiPomocni as $pomocniKredit){

                if($pomocniKredit->kredit_glavna_tabela_id == 58 || $pomocniKredit->kredit_glavna_tabela_id == 222|| $pomocniKredit->kredit_glavna_tabela_id == 582){

                    $glavniKreditId= $pomocniKredit->kredit_glavna_tabela_id;
                    $pomocniKredit= $pomocniKredit->toArray();

                    $glavniKreditData =$this->dpsmKreditiInterface->getById($glavniKreditId)->toArray();
                    $test='test';
                }
                $test='test';


            }
//        }

        return $allData;
}

}
