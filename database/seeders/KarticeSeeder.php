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

class KarticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = $this->getPartnerArray2();

        foreach ($datas as $data) {
            try {
                if($data['DATUM_K']!==''){
                    $datum_k =$this->resolvedate($data['DATUM_K']);

                }else{
                    $datum_k=null;

                }
                if($data['DATUM_D']!==''){
                    $datum_d =$this->resolvedate($data['DATUM_D']);
                }else{
                    $datum_d=null;
                }



                DB::table('kartices')->insert([
                    'sd' => $data['SD'],
                    'idbr' => $data['IDBR'],
                    'poz' => $data['POZ'],
                    'magacin_id' => (int)$data['SM'],
                    'materijal_id' => (int)$data['SIFRA_M'],
                    'datum_k' => $datum_k,
                    'datum_d' =>$datum_d,
                    'kolicina' => (float)$data['KOLICINA'],
                    'vrednost' => (float)$data['VREDNOST'],
                    'cena' => (float)$data['CENA'],
                    'konto' => $data['KONTO'],
                    'tc' => $data['TC'],
                    'poru' => $data['PORU'],
                    'norma' => (float)$data['NORMA'],
                    'veza' => $data['VEZA'],
                    'mesec' => $data['MESEC'],
                    'nal1' => $data['NAL1'],
                    'nal2' => $data['NAL2'],
                    'gru' => $data['GRU'],
                ]);

            } catch (Exception $exception) {
                if(str_contains($exception->getMessage(),'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails')){
                    Log::channel('check_materijal_import_errors')->debug('Kartice, ne postoji materijal: Sifra: '.$data['SIFRA_M']);

                }

                if(!str_contains($exception->getMessage(),'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails')){
                    Log::channel('check_materijal_import_errors')->debug('Kartice, Drugi error: Sifra: '.$data['SIFRA_M']);

                }

                Log::error('Error processing mat Kartice: ' . $exception->getMessage());

            }

        }

    }

    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/materijalno_25_09_2024/PIP.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
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
}
