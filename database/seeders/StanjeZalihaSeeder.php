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
use Illuminate\Support\Facades\Log;

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

                $existingMaterijal = \App\Models\Materijal::where('sifra_materijala', (int)$data['SIFRA_M'])->first();

                // Ako materijal ne postoji, kreiraj ga sa minimalnim informacijama
                if (!$existingMaterijal) {
                    $existingMaterijal = \App\Models\Materijal::create([
                        'sifra_materijala' => (int)$data['SIFRA_M'],
                        // Ostali detalji nisu dostupni u CSV, postavljamo podrazumevane vrednosti
                        'naziv_materijala' => 'Neodređen materijal',
                        'category_id' => 88888, // Možeš staviti neki default ID kategorije, ako imaš definisano
                        'standard' => null,
                        'dimenzija' => null,
                        'kvalitet' => null,
                        'jedinica_mere' => null,
                        'tezina' => 0,
                        'dimenzije' => null,
                        'sifra_standarda' => null,
                        'napomena' => null,
                    ]);
                }


                DB::table('stanje_zalihas')->insert([
                    'magacin_id' => (int)$data['SM'], // Šifra magacina
                    'sifra_materijala' => (int)$data['SIFRA_M'], // Šifra materijala
                    'konto' => $data['KONTO'], // Konto
                    'cena' => (float)$data['CENA'], // Cena
                    'kolicina' => (float)$data['KOLICINA'], // Trenutna količina
                    'vrednost' => (float)$data['VREDNOST'], // Trenutna vrednost
                    'pocst_kolicina' => (float)$data['POCST_K'], // Početna količina
                    'pocst_vrednost' => (float)$data['POCST_V'], // Početna vrednost
                    'ulaz_kolicina' => (float)$data['ULAZK'], // Količina ulaza
                    'ulaz_vrednost' => (float)$data['ULAZ_V'], // Vrednost ulaza
                    'izlaz_kolicina' => (float)$data['IZLAZK'], // Količina izlaza
                    'izlaz_vrednost' => (float)$data['IZLAZ_V'], // Vrednost izlaza
                    'stanje_kolicina' => (float)$data['STANJE_K'], // Trenutna količina stanja
                    'stanje_vrednost' => (float)$data['STANJE_V'], // Trenutna vrednost stanja
                    'st_mag' => (float)$data['ST_MAG'], // Specifična vrednost u magacinu
                ]);

            } catch (Exception $exception) {
                Log::channel('check_materijal_import_errors')->debug('Stanje zaliha, ne postoji materijal: Sifra: '.$data['SIFRA_M']);

            }

        }

    }

    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/materijalno_25_09_2024/STM.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
