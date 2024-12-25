<?php

namespace App\Console\Commands;

use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppCheckUpdateUnosPoentera extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:checkUpdateUnosPoentera';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Komanda koja proverava projekat';

    /**
     * Execute the console command.
     */




    public function handle()
    {

        $poenterUnos = $this->getUnosPoentera();

        $nePostoji=[];
        foreach ($poenterUnos as $data) {

            $test='test';
            $dpsm =Mesecnatabelapoentaza::where('maticni_broj',$data['maticni_broj'])->first();

            if($dpsm!==null){

                $dpsm->vrste_placanja=$data['vrste_placanja'];
                $dpsm->save();
//                $test='test';

            }else{
                $nePostoji[]=$data['maticni_broj'];
            }

        }


        $this->alert('Ne postoje u bazi: '. json_encode($nePostoji));
    }



    public function getUnosPoentera()
    {
        $filePath = storage_path('app/backup/plata_25_12_2024/unos_poentera_plus_rs_25_12_2024_novembar.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
