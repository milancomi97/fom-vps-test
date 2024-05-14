<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;

class CheckData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-data {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $datas = $this->getDataFromCsv();
        $bar = $this->output->createProgressBar(count($datas));

        $bar->start();

        foreach ($datas as $data) {
            $this->info('Maticni broj: '.$data['MBRD']);
            $bar->advance();

        }
        $bar->finish();





        $this->askWithCompletion('Koji podatak zelite da proverite ?',['1','2']);
//        $this->info('Provera podataka za ID: '.$id);
//        $this->comment('Provera podataka za ID: '.$id);
//        $this->question('Provera podataka za ID: '.$id);
//        $this->error('Provera podataka za ID: '.$id);
//        $this->warn('Provera podataka za ID: '.$id);

        $this->alert('Komanda je uspesno izvrsena');
    }



    public function getDataFromCsv()
    {
        $filePath = storage_path('app/backup/novo/MDR.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }
}
