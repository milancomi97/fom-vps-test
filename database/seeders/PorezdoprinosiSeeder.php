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
                'mesec' =>substr($data['M_G'], 0, 2),
                'godina' => '20'.substr( $data['M_G'], -2),
                'opis0_opis_iznos_poreskog_oslobadjanja' => $data['OPPOR'],
                'izn1_iznos_poreskog_oslobadjanja' => $data['IZN1'],
                'oppor_opis_poreza' => $data['porezNaLicnaPrimanja'],
                'p1_porez' => str_replace(",", ".", $data['porezNaLicnaPrimanja']), // TODO CHECKK
                'opis1_opis_zdravstvenog_osiguranja_na_teret_radnika' => $data['ZDRO'],
                'zdro_zdravstveno_osiguranje_na_teret_radnika' => str_replace(",", ".",$data['ZDRO']),
                'opis2_opis_pio_na_teret_radnika' => $data['OPIS2'],
                'pio_pio_na_teret_radnika' => str_replace(",", ".",$data['PIO']),
                'opis3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika' => $data['OPIS3'],
                'onez_osiguranje_od_nezaposlenosti_na_teret_radnika' => str_replace(",", ".",$data['ONEZ']),
                'ukdop_ukupni_doprinosi_na_teret_radnika' => str_replace(",", ".",$data['UKDOPR']),
                'opis4_opis_zdravstvenog_osiguranja_na_teret_poslodavca' => $data['OPIS4'],
                'dopzp_zdravstveno_osiguranje_na_teret_poslodavca' => str_replace(",", ".",$data['DOPRA']),
                'opis5_opis_pio_na_teret_poslodavca' => $data['OPIS5'],
                'dopp_pio_na_teret_poslodavca' => str_replace(",", ".",$data['DOPRB']),
                'ukdopp_ukupni_doprinosi_na_teret_poslodavca' => str_replace(",", ".",$data['DOPRB']) // TODO CHECK
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/DPOR2.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }

}
