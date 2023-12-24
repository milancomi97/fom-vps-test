<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class VrsteplacanjaSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('vrsteplacanjas')->insert([
                'rbvp_sifra_vrste_placanja' => $data['RBVP'],
                'naziv_naziv_vrste_placanja' => $data['NAZI'],
                'formula_formula_za_obracun' => $data['BLOK'],
                'redosled_poentaza_zaglavlje' => $data['REDOSLED_POENTAZA'],
                'redosled_poentaza_opis' => $data['REDOSLED_POENTAZA_OPIS']
            ]);
        }
    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/DVPL_2EXTEND.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }

}
