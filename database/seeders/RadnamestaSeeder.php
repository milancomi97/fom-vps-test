<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class RadnamestaSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('radnamestas')->insert([
                'rbrm_sifra_radnog_mesta' => $data['RBRM'],
                'narm_naziv_radnog_mesta' => $data['NARM']
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/Radna_mesta.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }
}
