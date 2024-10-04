<?php

namespace Database\Seeders;

use App\Enums\PartnerFields;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Exception;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = $this->getPartnerArray2();

        foreach ($datas as $data) {
            try {

                DB::table('partners')->insert([
                'name' => $data['NAKOM'],
                'address' => $data['ADKOM'],
                'internal_sifra' =>$data['MBKOM'],
                'short_name' => $data['SNKOM'],
//                'contact_employee' => $data['contact_employee'],
                'pib' => random_int(1,1000000000),
//                'phone' => $data['phone'],
//                'web_site' =>$data['web_site'],
//                'sifra_delatnosti' => $data['sifra_delatnosti'],
//                'odgovorno_lice' => $data['odgovorno_lice'],
//                'maticni_broj' => $data['maticni_broj'],
//                'mesto' => $data['mesto'],
                'pripada_pdvu' => true,
                'active' =>true,


            ]);
            } catch (Exception $exception ){

                $testt='test';
            }
        }

    }

    public function getPartnerArray()
    {
        $file = Storage::disk('local')->readStream('backup/materijalno_25_09_2024/KOM1.csv');
        if ($file !== false) {
            $datas = [];
            while (($row = fgetcsv($file)) !== false) {
                $datas[] = $row;
            }
            fclose($file);

            // Use the $data array as needed
            print_r($datas);
        } else {
            echo "Failed to open the CSV file.";
        }

        $dataDataArray = [];
        foreach ($datas as $key => $data) {

            if ($key == 0) {
                continue;
            } else {
                $dataData = (explode(";", $data[0]));

                foreach ($dataData as $keyPartner => $dataField) {

                    $columnNames = explode(";", $datas[0][0]);

                    try {
                        $dataDataArray[$key][$columnNames[$keyPartner]] = $dataField;
                    } catch (\Exception $exception){

                    }

//                        $dataDataArray[$key][$columnNames[$keyPartner]] = $dataField;
                }
            }
        }

        return $dataDataArray;
    }


    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/materijalno_25_09_2024/KOM1.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
