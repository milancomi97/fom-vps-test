<?php

namespace Database\Seeders;

use App\Enums\PartnerFields;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Exception;

class DokumentSifarnikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = $this->getPartnerArray2();

        foreach ($datas as $data) {
            try {

                DB::table('dokument_sifarniks')->insert([
                    'sd' => $data['SD'],
                    'dokument' => $data['DOKUMENT'],
                    'vred' => (isset($data['VRED']) && $data['VRED']=='TRUE')? 0 : 1,
            ]);
            } catch (Exception $exception ){

                $testt='test';
            }
        }

    }


    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/materijalno_25_09_2024/DOK.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
