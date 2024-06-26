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
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class DatotekaobracunskihKoefMesecDataSeeder extends Seeder
{

    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,

    ){
    }

    public function run(): void
    {
        var_dump('test');
        $podaciMesec = $this->getDataFromCsvPodaciMesec();

        foreach ($podaciMesec as $data2) {

            $newDataPodaciMesec[]=$data2;
        }

        $monthData='';

        foreach ($newDataPodaciMesec as $data){
                $test = 'test';

                $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);


            try {
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
                    'status' => $data['M_G'] == '0324' ? Datotekaobracunskihkoeficijenata::AKTUELAN : Datotekaobracunskihkoeficijenata::ARHIVIRAN,
                    'period_isplate_od' => Carbon::createFromFormat('d/m/Y', $data['DATUM1']),
                    'period_isplate_do' => Carbon::createFromFormat('d/m/Y', $data['DATUM2']),

                ]);

            } catch (\Exception $exception){
                var_dump($exception->getMessage());
            }
//                $monthData = $this->datotekaobracunskihkoeficijenataInterface->where('kalendarski_broj_dana', $data['DANI'])->get()->first();
            }


        }


    public function getDataFromCsvPodaciMesec()
    {
        $filePath = storage_path('app/backup/novo/DKOE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }



}
