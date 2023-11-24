<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class OblikradaSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('oblikradas')->insert([
                'sifra_oblika_rada' => $data['SIFRA'],
                'naziv_oblika_rada' => $data['NAZIV']
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/PRO.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }
}
