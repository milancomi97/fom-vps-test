<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Reader;
use Exception;
use Illuminate\Support\Facades\Log;

class PorudzbineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = $this->getPartnerArray2();

        foreach ($datas as $data) {
            try {
                if($data['DIDENT']!==''){
                    $dident =$this->resolvedate($data['DIDENT']);

                }else{
                    $dident=null;

                }
                if($data['DCLOSE']!==''){
                    $dclose =$this->resolvedate($data['DCLOSE']);
                }else{
                    $dclose=null;
                }


                // Unos podataka u tabelu porudzbinas
                DB::table('porudzbines')->insert([
                    'rbpo' => $data['RBPO'], // Šifra porudžbine
                    'napo' => $data['NAPO'], // Naziv porudžbine
                    'mbkom' => $data['MBKOM'], // Šifra poslovnog partnera
                    'dident' => $dident, // Datum otvaranja porudžbine
                    'dclose' => $dclose, // Datum zatvaranja porudžbine
                    'ugovor' => $data['UGOVO'], // Ugovor
                ]);

            } catch (Exception $exception) {
                if(str_contains($exception->getMessage(),'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails')){
                    Log::channel('check_materijal_import_errors')->debug('Porudzbine, ne postoji materijal: Sifra: '.$data['SIFRA_M']);

                }

                if(!str_contains($exception->getMessage(),'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails')){
                    Log::channel('check_materijal_import_errors')->debug('Porudzbine, Drugi error: Sifra: '.$data['SIFRA_M']);

                }

                Log::error('Error processing mat Porudzbine: ' . $exception->getMessage());

            }

        }

    }



    public function resolvedate($datum)
    {


        if ($datum !== '') {
            $date = Carbon::createFromFormat('m/d/Y', $datum);
            if ($date->year < 1930) {
                $date->addYears(100);// Add 100 years to the date
            }
            return $date->format('Y-m-d');
        } else {
            return null;
        }
    }

    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/materijalno_25_09_2024/PORU.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
