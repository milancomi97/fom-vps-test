<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class MinimalnebrutoosnoviceSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('minimalnebrutoosnovices')->insert([
                'mesec' => substr($data['mesecGodina'], 0, 2),
                'godina' =>'20'.substr( $data['mesecGodina'], -2),
                'nt1_prosecna_mesecna_osnovica' => $data['mesecGodina'], // TODO this
                'stopa2_minimalna_neto_zarada_po_satu' => str_replace(",", ".", $data['STOPA2']),
                'stopa6_koeficijent_najvise_osnovice_za_obracun_doprinos' => str_replace(",", ".",$data['StopaZaUtvrdjivanjeMaksimalneOsnoviceZaDoprinose']),
                'p1_stopa_poreza' => str_replace(",", ".",$data['PorezNaLicnaPrimanja']),
                'stopa1_koeficijent_za_obracun_neto_na_bruto' => str_replace(",", ".",$data['STOPA1']),
                'nt3_najniza_osnovica_za_placanje_doprinos' => str_replace(",", ".",$data['minimalnaOsnovicaZaDoprinose']),
                'nt2_minimalna_bruto_zarada' => str_replace(",", ".",$data['minimalnaBrutoZarada'])
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/DNTO2.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }

}
