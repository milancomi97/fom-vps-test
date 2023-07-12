<?php

namespace Database\Seeders;

use App\Enums\PartnerFields;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $partners = $this->getPartnerArray();

        // CSV WITHOUT ,
        // CSV WITH THIS COULUMN NAMES
        foreach ($partners as $partner) {
            DB::table('partners')->insert([
                'name' => $partner['name'],
                'email' => $partner['email'],
                'short_name' => $partner['short_name'],
                'contact_employee' => $partner['contact_employee'],
                'pib' => $partner['pib'],
                'phone' => $partner['phone'],
                'web_site' =>$partner['web_site'],
                'sifra_delatnosti' => $partner['sifra_delatnosti'],
                'odgovorno_lice' => $partner['odgovorno_lice'],
                'maticni_broj' => $partner['maticni_broj'],
//                'registarski_broj' =>$partner['registarski_broj'],
                'registarski_broj' =>"Undefinded",
                'mesto' => $partner['mesto'],
                'pripada_pdvu' => $partner['pripada_pdvu'] =="1",
                'active' =>$partner['active'] =="1",
                'address' => $partner['address'],
                'internal_sifra' =>$partner['internal_sifra']

            ]);
        }

    }

    public function getPartnerArray()
    {
        $file = Storage::disk('local')->readStream('backup/PoslovniPartneri.csv');
        if ($file !== false) {
            $partners = [];
            while (($row = fgetcsv($file)) !== false) {
                $partners[] = $row;
            }
            fclose($file);

            // Use the $data array as needed
            print_r($partners);
        } else {
            echo "Failed to open the CSV file.";
        }

        $partnerDataArray = [];
        foreach ($partners as $key => $partner) {

            if ($key == 0) {
                continue;
            } else {
                $partnerData = (explode(";", $partner[0]));

                foreach ($partnerData as $keyPartner => $partnerField) {

                    $columnNames = explode(";", $partners[0][0]);

                    try {
                        $partnerDataArray[$key][$columnNames[$keyPartner]] = $partnerField;
                    } catch (\Exception $exception){

                    }

//                        $partnerDataArray[$key][$columnNames[$keyPartner]] = $partnerField;
                }
            }
        }

        return $partnerDataArray;
    }
}
