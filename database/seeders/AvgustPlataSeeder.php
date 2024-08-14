<?php

namespace Database\Seeders;

use App\Models\Datotekaobracunskihkoeficijenata;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

class AvgustPlataSeeder extends Seeder
{

    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficiente,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly KreirajPermisijePoenteriOdobravanja                 $kreirajPermisijePoenteriOdobravanja,
        private readonly PermesecnatabelapoentRepositoryInterface            $permesecnatabelapoentInterface,
        private readonly DpsmPoentazaslogRepositoryInterface                 $dpsmPoentazaslogInterface,
        private readonly DpsmFiksnaPlacanjaRepositoryInterface               $dpsmFiksnaPlacanjaInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly VrsteplacanjaRepositoryInterface          $vrsteplacanjaInterface,
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface,
        private readonly RadniciRepositoryInterface $radniciInterface,

    ){
    }

    public function run(): void
    {
        Log::channel('user_action')->debug('Test custom logger START MART');

        var_dump('test');
        $podaciMesec = $this->getDataFromCsvPodaciMesec();

        $mdrData=$this->getDataFromCsvMDR();
        $userData=$this->getDataFromCsvUser();
        $varijabilnaP = $this->getDataFromCsvVarijabilnaP();

        // 1. Check if all mdr exists
         $checkData= $this->checkExistData($mdrData,$userData,$varijabilnaP);
        if($checkData){

        }

//        $varijabilneVrtsePlacanjaReader = $this->getDataFromCsvFiksnaP();
//        $kreditiReader = $this->getDataFromCsvKrediti();
        $monthId = 0;

        foreach ($podaciMesec as $data2) {

            $newDataPodaciMesec[]=$data2;
        }


            $monthData='';







        // STARA LOGIKA IMPORTA START
        foreach ($newDataPodaciMesec as $data){
            if ($data['M_G'] == '0324') {
                $test = 'test';

                $date = Carbon::createFromFormat('my', '0724')->startOfMonth()->setDay(1);


                $monthRecord = DB::table('datotekaobracunskihkoeficijenatas')->insert([
                    'kalendarski_broj_dana' => $data['DANI'],
                    'mesecni_fond_sati' => $data['BR_S'],
                    'prosecni_godisnji_fond_sati' => $data['S3'],
                    'cena_rada_tekuci' => $data['C_R'],
                    'mesecni_fond_sati_praznika' => 0,
                    'cena_rada_prethodni' => $data['C_R2'],
                    'vrednost_akontacije' => 0,
                    'datum' => $date->format('Y-m-d'),
                    'mesec'=>$date->month,
                    'godina' =>$date->year,
                    'status' => Datotekaobracunskihkoeficijenata::AKTUELAN,
                    'period_isplate_od' => Carbon::createFromFormat('d/m/Y', $data['DATUM1']),
                    'period_isplate_do' => Carbon::createFromFormat('d/m/Y', $data['DATUM2']),

                ]);

                $monthData = $this->datotekaobracunskihkoeficijenataInterface->where('kalendarski_broj_dana', $data['DANI'])->get()->first();

            }
        }


        if ($monthData) {
            $monthId = $monthData->id;

            $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();

            $podaciRadniciMesec = $this->kreirajObracunskeKoeficiente->otvoriAktivneRadnikeImport($monthData, $varijabilnaP,$vrstePlacanjaSifarnik);
            $resultDatoteka = $this->mesecnatabelapoentazaInterface->createMany($podaciRadniciMesec);


            $resultPMB = $this->kreirajPermisijePoenteriOdobravanja->execute($monthData);
            $resultPermission = $this->permesecnatabelapoentInterface->createMany($resultPMB);
            $idRadnikaZaMesec = $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id', $monthData->id)->select(['id', 'maticni_broj'])->get();

            $variabilnaUpdateData = $this->dpsmPoentazaslogInterface->where('obracunski_koef_id', $monthData->id)->get();

            foreach ($variabilnaUpdateData as $variabilnoP) {
                $idRadnikaDPSM = $this->mesecnatabelapoentazaInterface->where('maticni_broj', $variabilnoP->maticni_broj)->first()->id;
                $variabilnoP->user_dpsm_id = $idRadnikaDPSM;
                $variabilnoP->save();
            }



        }
        // STARA LOGIKA IMPORTA START END

        Log::channel('user_action')->debug('Test custom logger END MART');

    }

    public function getDataFromCsvPodaciMesec()
    {
        $filePath = storage_path('app/backup/novo/DKOE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv->getRecords();
    }

    public function getDataFromCsvVarijabilnaP()
    {

        $filePath = storage_path('app/backup/avgustPlata/DPSM_2.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv->getRecords();
    }
    public function getDataFromCsvMDR()
    {

        $filePath = storage_path('app/backup/avgustPlata/MDR.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv->getRecords();
        var_dump($records);
        return $csv;
    }

    public function getDataFromCsvUser(){


            $filePath = storage_path('app/backup/avgustPlata/KADR.csv');
            $csv = Reader::createFromPath($filePath, 'r');
            $csv->setHeaderOffset(0);
            $csv->setDelimiter(',');
        return $csv->getRecords();

    }

//    public function getDataFromCsvFiksnaP()
//    {
//        $filePath = storage_path('app/backup/novo/DFVP.csv');
//        $csv = Reader::createFromPath($filePath, 'r');
//        $csv->setHeaderOffset(0);
//        $csv->setDelimiter(',');
//        return $csv;
//    }
//
//    public function getDataFromCsvKrediti()
//    {
//        $filePath = storage_path('app/backup/novo/MKRE.csv');
//        $csv = Reader::createFromPath($filePath, 'r');
//        $csv->setHeaderOffset(0);
//        $csv->setDelimiter(',');
//        return $csv;
//    }


    public function checkExistData($mdrData,$userData,$varijabilnaP){

        $mdrCounter=0;
        $userCounter=0;

        foreach ($mdrData as $mdr){
            $mdrCounter++;


            $maticniBroj=$mdr['MBRD'];
            $aktivan=$mdr['ACTIVE'];

//            var_dump('Mdr: '.$maticniBroj);
        }

        foreach ($userData as $user){
            $userCounter++;

            $maticniBroj=$user['MBRD'];
            $aktivan=$user['ACTIVE'];
//            var_dump('User: '.$maticniBroj);
        }

        foreach ($varijabilnaP as $placanje) {
           $maticniBroj =  $placanje['MBRD'];

            $userData = $this->radniciInterface->where('maticni_broj',$maticniBroj)->get();
            $mdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$maticniBroj)->get();


            if($userData->count()==0){
                var_dump('userData:'.$userData->count().'-'.$maticniBroj);
                var_dump('mdrData:'.$mdrData->count().'-'.$maticniBroj);
//                return false;
//                0006725
                //0006725
                //0006729
            }


        }
        var_dump('Count Mdr data:'. $mdrCounter);
        var_dump('Count KADR/User data:'. $userCounter);
        return true;
    }
}
