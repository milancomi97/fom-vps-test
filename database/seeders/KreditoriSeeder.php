<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class KreditoriSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('kreditoris')->insert([
                'sifk_sifra_kreditora' => $data['SIFK'],
                'imek_naziv_kreditora' => $data['IMEK'],
                'sediste_kreditora' => $data['SEDI'],
                'tekuci_racun_za_uplatu' => $data['ZRAC'],
                'partija_kredita' => $data['PART']
//                POBR

            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/novo/DKRE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

}
