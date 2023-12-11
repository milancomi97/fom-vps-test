<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class OrganizacionecelineSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('organizacionecelines')->insert([
                'id'=>$data['sifra_troskovnog_mesta'],
                'sifra_troskovnog_mesta' =>$data['sifra_troskovnog_mesta'],
                'naziv_troskovnog_mesta' =>$data['naziv'],
                'active'=>$data['Aktivno_Neaktivno'] == "TAČNO",
            ]);
        }

    }

    public function getDataFromCsv()
    {
        $filePath = storage_path('app/backup/TroskovnaMesta.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }

}
