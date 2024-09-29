<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Reader;
use Exception;

class MagacinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $magacini = $this->getPartnerArray2();
        $errors=[];

        foreach ($magacini as $magacin) {
            try {
                    $category = \App\Models\Magacin::create([
                        'id' => (int)$magacin['SM'],
                        'sm' => $magacin['SM'],
                        'name' => $magacin['MAGACIN'],
                    ]);

//            } catch (QueryException $exception ){ Ovako ovo radi
            } catch (Exception $exception ){
                $errors[]= $exception->getMessage();

            }

        }


    }

    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/materijalno_25_09_2024/MAG.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
