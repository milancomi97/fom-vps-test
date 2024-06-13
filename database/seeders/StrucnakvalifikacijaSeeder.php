<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class StrucnakvalifikacijaSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('strucnakvalifikacijas')->insert([
                'sifra_kvalifikacije' => $data['SIFRA'],
                'naziv_kvalifikacije' => $data['NAZIV'],
                'skraceni_naziv_kvalifikacije' => $data['NAZIV_PUN']
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/novo/STRUCNA_.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

}
