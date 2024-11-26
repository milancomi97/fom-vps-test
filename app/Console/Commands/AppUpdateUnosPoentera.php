<?php

namespace App\Console\Commands;

use App\Models\DpsmKrediti;
use App\Models\Kreditori;
use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class AppUpdateUnosPoentera extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updateUnosPoenera';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Komanda koja sredjuje projekat';

    /**
     * Execute the console command.
     */

    public function __construct(
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface
    ){
        parent::__construct();
    }
    public function handle()
    {

        $dpsmData= $this->getDpsmData();

        foreach ($dpsmData as $radnikData){

        }



    }


    public function getDpsmData()
    {
        $filePath = storage_path('app/backup/kredit_19_11_2024/MKRE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }

}
