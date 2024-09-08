<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        foreach ($materijals as $materijal) {
            try {
                DB::table('materijals')->insert([
                    'category_id'=>(int)$materijal['GRUPA'],
                    'sifra_materijala'=>(int)$materijal['SIFRA_Materijala'],
                    'naziv_materijala'=>$materijal['NAZIV_Materijala'],
                    'standard'=>$materijal['STANDARD'],
                    'dimenzija'=>$materijal['DIMENZIJA'],
                    'kvalitet'=>$materijal['KVALITET'],
                    'jedinica_mere'=>$materijal['JM'],
                    'tezina'=>(int)$materijal['TEZINA'],
                    'dimenzije'=>$materijal['DIMENZIJE'],
                    'dimenzija_1'=>$materijal['DIM1'],
                    'dimenzija_2'=>$materijal['DIMEN2'],
                    'dimenzija_3'=>$materijal['DIM3'],
                    'dimenzija_4'=>$materijal['DIMEN3'],
                    'sifra_standarda'=>$materijal['SIFRA_S'],
                    'napomena'=>$materijal['NAPOMENA']
                ]);

//            } catch (QueryException $exception ){ Ovako ovo radi
            } catch (Exception $exception ){

                $testt='test';
            }

        }

    }

    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/Materijali.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
