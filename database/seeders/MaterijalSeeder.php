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

class MaterijalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materijals = $this->getPartnerArray2();
        $errors=[];
        $category = \App\Models\Category::create([
            'id' => 9999998,
            'gru' => 9999998,
            'name' => 'Pomocna kategorija nedefinisana'
        ]);
        foreach ($materijals as $materijal) {
            try {
                $category = \App\Models\Category::where('gru', (int)$materijal['GRU'])->first();

                // Ako kategorija ne postoji, kreiraj novu sa nazivom UNDEFINED.SIFRA KATEGORIJE
                if (!$category) {
                    $category = \App\Models\Category::create([
                        'id' => (int)$materijal['GRU'],
                        'gru' => (int)$materijal['GRU'],
                        'name' => 'Neopredeljena, dogovor, ' . (int)$materijal['GRU'],
                    ]);
                }

                DB::table('materijals')->insert([
                    'category_id'=>(int)$materijal['GRU'],
                    'sifra_materijala'=>(int)$materijal['SIFRA_M'],
                    'naziv_materijala'=>$materijal['NAZIV_M'],
                    'standard'=>$materijal['STANDARD'],
                    'dimenzija'=>$materijal['DIMENZIJA'],
                    'kvalitet'=>$materijal['KVALITET'],
                    'jedinica_mere'=>$materijal['JM'],
                    'tezina'=>(float)$materijal['TEZINA'],
                    'dimenzije'=>$materijal['DIMENZIJA'],
                    'dimenzija_1_value'=>$materijal['DIMEN1'],
                    'dimenzija_1'=>$materijal['DIM1'],
                    'dimenzija_2_value'=>$materijal['DIMEN2'],
                    'dimenzija_2'=>$materijal['DIM2'],
                    'dimenzija_3_value'=>$materijal['DIMEN3'],
                    'sifra_standarda'=>$materijal['SIFRA_S'],
                    'napomena'=>$materijal['NAPOMENA'],
                    'konto'=>$materijal['KONTO']
                ]);

//            } catch (QueryException $exception ){ Ovako ovo radi
            } catch (Exception $exception ){

                $errors[]= $exception->getMessage();
//                if(!str_starts_with($exception->getMessage(),'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry')){
               $test='test';
                    Log::channel('check_materijal_import_errors')->debug('Materijal, ne postoji materijal: Sifra: '. $exception->getMessage());

//                }


            }

        }


    }

    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/materijalno_25_09_2024/MAT_3.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
