<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('categories')->insert([
                'id' => $data['GRU'],
                'gru' => $data['GRU'],
                'name'=>$data['NAZIV']
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/materijalno_25_09_2024/GRU.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
