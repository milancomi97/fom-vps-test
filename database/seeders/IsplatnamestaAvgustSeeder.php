<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class IsplatnamestaAvgustSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('isplatnamestas')->insert([
                'rbim_sifra_isplatnog_mesta' => $data['RBIM'],
                'naim_naziv_isplatnog_mesta' => $data['NAIM'],
                'tekuci_racun_banke' => $data['ZRAC'],
                'pb_poziv_na_broj' => $data['PB'],
                'partija_racuna' => $data['PART']
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/avgustPlataNovo/DIMR.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }
}
