<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class VrstaradasifarnikSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('vrstaradasifarniks')->insert([
                'sifra_statusa' => $data['SIFRA'],
                'naziv_statusa' => $data['NAZIV'],
                'svp_sifra_vrste_placanja' => $data['SVP']
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/VRSTE_PRIHODA_ZA_PPPD.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }

}
