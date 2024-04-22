<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class OpstineSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('opstines')->insert([
                'naziv_opstine' => $data['naziv_opstine'],
                'sifra_opstine' =>  '0'.$data['sifra'],
                'sifra_opstine_kontrolni_broj' => $data['sifra_sa_kontrolnim_brojem']
            ]);
        }
    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/sifarnik_opstina.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }

}
