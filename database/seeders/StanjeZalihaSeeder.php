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

class StanjeZalihaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = $this->getPartnerArray2();

        foreach ($datas as $data) {
            try {
                DB::table('stanje_zalihas')->insert([
                    'magacin_id'=>(int)$data['SM'],
                    'sifra_materijala'=>$data['SIFRA_Materijala'],
                    'naziv_materijala'=>$data['NAZIV'],
                    'dimenzija'=>$data['DIMENZIJA'],
                    'kvalitet'=>$data['KVALITET'],
                    'jedinica_mere'=>$data['JM'],
                    'konto'=>$data['KONTO'],
                    'pocst_kolicina'=>(int)$data['POCST_Kolicina'],
                    'pocst_vrednost'=>(int)$data['POCST_Vrednost'],
                    'ulaz_kolicina'=>(int)$data['ULAZKolicina'],
                    'ulaz_vrednost'=>(int)$data['ULAZ_Vrednost'],
                    'izlaz_kolicina'=>(int)$data['IZLAZKolicina'],
                    'izlaz_vrednost'=>(int)$data['IZLAZ_Vrednost'],
                    'stanje_kolicina'=>(int)$data['STANJE_Kolicina'],
                    'stanje_vrednost'=>(int)$data['STANJE_Vrednost'],
                    'cena'=>(int)$data['CENA'],

                ]);

//            } catch (QueryException $exception ){ Ovako ovo radi
            } catch (Exception $exception ){

            }

        }

    }

    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/StanjeZaliha.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }
}
