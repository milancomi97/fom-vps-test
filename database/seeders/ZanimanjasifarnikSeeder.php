<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ZanimanjasifarnikSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('zanimanjasifarniks')->insert([
                'sifra_zanimanja'=>$data['SIFRA'],
                'naziv_zanimanja'=>$data['NAZIV']
            ]);
        }

    }


    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/ZANIMANJA.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }

}
