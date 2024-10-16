<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ArhivaDarhObradaSveDkopSeeder extends Seeder
{
    public function __construct(
        private readonly VrsteplacanjaRepositoryInterface $vrsteplacanjaInterface,
    )
    {
    }

    public function run(): void
    {
        $datas = $this->getDataFromCsv();
        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();

        foreach ($datas as $data) {
            $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);

            try{
            DB::table('arhiva_darh_obrada_sve_dkops')->insert([
                'M_G_mesec_godina' =>$data['M_G'],
                'M_G_date' =>$date->format('Y-m-d'),
                'maticni_broj'=>$data['MBRD'],
                'sifra_vrste_placanja'=>$data['RBVP'],
                'naziv_vrste_placanja'=>isset($sifarnikVrstePlacanja[$data['RBVP']]) ? $sifarnikVrstePlacanja[$data['RBVP']]['naziv_naziv_vrste_placanja']: 'SIFRA NE POSTOJI U TRENUTNOM SIFARNIKU',
                'SLOV_grupa_vrste_placanja'=>$data['SLOV'],
                'sati'=>$data['SATI'],
                'iznos'=>$data['IZNO'],
                'procenat'=>$data['PERC'],
                'SALD_saldo'=>$data['SALD'],
                'POK2_obracun_minulog_rada'=>$data['POK2'],
                'KOEF_osnovna_zarada'=>$data['KOEF'],
                'RBRM_radno_mesto'=>$data['RBRM'],
                'KESC_prihod_rashod_tip'=>$data['KESC'],
                'P_R_oblik_rada'=>$data['P_R'],
                'SIFK_sifra_kreditora'=>$data['SIFK'],
                'STSALD_Prethodni_saldo'=>$data['STSALD'],
                'PART_partija_kredita'=>$data['PART'],

                ]);

        } catch (\Exception $e) {
        var_dump("Failed to create payment record for MBRD: ".json_encode($data).", Error: " . $e->getMessage());
    }
        }

    }



    public function getDataFromCsv()
    {
        $filePath = storage_path('app/backup/mts_server_priprema_14_10_2024/DARH.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
