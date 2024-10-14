<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Writer;

class ExportModelToCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'export:podaci {maticni_broj} {--podaci}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function podaciZaIspis(){


        $model = $this->argument('maticni_broj');

        $zaglavlje=['maticni_broj'];

        $podaci=[[$model]];


        return [
            'zaglavlje'=>$zaglavlje,
            'podaci'=>$podaci,
        ];
    }


    public function handle()
    {
        $filepath = storage_path('csv_files/model_export.csv');

        $data = $this->podaciZaIspis();



        // Create CSV writer instance
        $csv = Writer::createFromPath($filepath, 'w+');

        // Get column names from the model
        $columns = $data['zaglavlje'];

        // Insert header row
        $csv->insertOne($columns);

        // Insert data rows
        foreach ($data['podaci'] as $row) {
            $csv->insertOne($row);
        }

        $csv->output(); // This will print CSV content directly to the console

    }
}
