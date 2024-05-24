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

//        public CONST RUKOVODILAC_POGONA=1;
//        public CONST RUKOVODILAC_POGONA=1;
//        public CONST RUKOVODILAC_POGONA=1;
//        public CONST RUKOVODILAC_POGONA=1;
//        public CONST RUKOVODILAC_POGONA=1;

        foreach ($datas as $data) {

            try {
                DB::table('organizacionecelines')->insert([
                    'id'=>$data['RBTC'],
                    'sifra_troskovnog_mesta' =>$data['RBTC'],
                    'naziv_troskovnog_mesta' =>$data['NATC'],
                    'active'=>$data['ACTIVE'] == "TAČNO",
                    'poenteri_ids'=>'["1450","1596","1598","2692"]', //User Model ID
                    'odgovorna_lica_ids'=>'["2540", "2130"]',  // User Model ID
                    'odgovorni_direktori_pravila'=>$this->resolveDirektori($data)
                ]);

            } catch (\Exception $exception){
                var_dump(PHP_EOL.$exception->getMessage().PHP_EOL);
            }

        }

    }





    public function getDataFromCsv()
    {
//        $filePath = storage_path('app/backup/TroskovnaMesta.csv'); staro
        $filePath = storage_path('app/backup/novo/TCR.csv');

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }


    public function resolveDirektori($data)
    {
        $dataArray = [];
        if ($data['SEF'] !== '') {

            $dataArray[] = $data['GEND'];
        }

        if ($data['RUKOD'] !== '') {
            $dataArray[] = $data['RUKOD'];

        }
        if ($data['POMD'] !== '') {
            $dataArray[] = $data['POMD'];

        }

        if ($data['DIRD'] !== '') {
            $dataArray[] = $data['DIRD'];

        }
        if ($data['GEND'] !== '') {
            $dataArray[] = $data['GEND'];

        }

        return json_encode($dataArray);
    }

}
