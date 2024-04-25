<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class PorezdoprinosiSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();


        foreach ($datas as $data) {

            DB::table('porezdoprinosis')->insert([
                'M_G_mesec_godina' => $data['M_G'],
                'IZN1_iznos_poreskog_oslobodjenja' => $data['IZN1'],
                'OPPOR_opis_poreza' => $data['OPPOR'],
                'P1_porez_na_licna_primanja' => str_replace(",", ".",$data['P1']),
                'OPIS1_opis_zdravstvenog_osiguranja_na_teret_radnika' => $data['OPIS1'],
                'ZDRO_zdravstveno_osiguranje_na_teret_radnika' => str_replace(",", ".",$data['ZDRO']),
                'OPIS2_opis_pio_na_teret_radnika' => $data['OPIS2'],
                'PIO_pio_na_teret_radnika' => str_replace(",", ".",$data['PIO']),
                'OPIS3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika' => $data['OPIS3'],
                'ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika' => str_replace(",", ".",$data['ONEZ']),
                'UKDOPR_ukupni_doprinosi_na_teret_radnika' => str_replace(",", ".",$data['UKDOPR']),
                'OPIS4_opis_zdravstvenog_osiguranja_na_teret_poslodavca' => $data['OPIS4'],
                'DOPRA_zdravstveno_osiguranje_na_teret_poslodavca' => str_replace(",", ".",$data['DOPRA']),
                'OPIS5_opis_pio_na_teret_poslodavca' => $data['OPIS5'],
                'DOPRB_pio_na_teret_poslodavca' => str_replace(",", ".",$data['DOPRB'])
//                'UKDOPP_ukupni_doprinosi_na_teret_poslodavca' => $data['UKDOPP'],
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/novo/DPOR.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

}
