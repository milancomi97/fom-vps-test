<?php

namespace Database\Seeders;

use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

//            try {
                DB::table('organizacionecelines')->insert([
                    'id'=>$data['RBTC'],
                    'sifra_troskovnog_mesta' =>$data['RBTC'],
                    'naziv_troskovnog_mesta' =>$data['NATC'],
                    'active'=>$data['ACTIVE'] == "TAČNO",
                    'poenteri_ids'=>$this->resolvePoenteri($data), //User Model ID
//                    'poenteri_ids'=>'["559","2140","1596","1603","2734","2735"]', //User Model ID
                    'odgovorna_lica_ids'=>'["2109"]',  // User Model ID
                    'odgovorni_direktori_pravila'=>$this->resolveDirektori($data)
                ]);

//            } catch (\Exception $exception){
//                var_dump(PHP_EOL.$exception->getMessage().PHP_EOL);
//            }

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

    public function resolvePoenteri($data){
        $users = UserPermission::where('role_id',2)->get();

        $test='test';
        $userIds=[];
        foreach ($users as $userData){

           $userPermission= json_decode($userData->troskovna_mesta_poenter,true);

           if($userPermission[$data['RBTC']]){
               $userIds[]=$userData->id;
           }
        }

        if(count($userIds)==0){
            $test='test';
            Log::channel('check_oc_poenters_sum')->debug($data['RBTC'].': 0 poentera');
        }elseif(count($userIds)==1){
            $test='test';
            Log::channel('check_oc_poenters_sum')->debug($data['RBTC'].': 1 poentera');
        }elseif(count($userIds)==2){
            $test='test';
            Log::channel('check_oc_poenters_sum')->debug($data['RBTC'].': 2 poentera');
        }elseif(count($userIds)==3){
            $test='test';
        Log::channel('check_oc_poenters_sum')->debug($data['RBTC'].': 3 poentera');
        }elseif(count($userIds)==4){
            $test='test';
            Log::channel('check_oc_poenters_sum')->debug($data['RBTC'].': 4 poentera');
        }

        $test='test';
        return json_encode($userIds);
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
