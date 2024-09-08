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
                'name' => $data['name'],
                'email' => $data['email'],
                'short_name' => $data['short_name'],
                'contact_employee' => $data['contact_employee'],
                'pib' => $data['pib'],
                'phone' => $data['phone'],
                'web_site' =>$data['web_site'],
                'sifra_delatnosti' => $data['sifra_delatnosti'],
                'odgovorno_lice' => $data['odgovorno_lice'],
                'maticni_broj' => $data['maticni_broj'],
                'mesto' => $data['mesto'],
                'pripada_pdvu' => $data['pripada_pdvu'] =="1",
                'active' =>$data['active'] =="1",
                'address' => $data['address'],
                'internal_sifra' =>$data['internal_sifra']

            ]);
            } catch (Exception $exception ){

                $testt='test';
            }
        }

    }

    public function getPartnerArray()
    {
        $file = Storage::disk('local')->readStream('backup/PoslovniPartneri.csv');
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
        $filePath = storage_path('app/backup/PoslovniPartneri.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
