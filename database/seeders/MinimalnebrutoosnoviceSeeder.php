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
                'M_G_mesec_dodina' =>$data['M_G'],
                'NT1_prosecna_mesecna_zarada_u_republici' => str_replace(",", ".",$data['NT1']),
                'STOPA2_minimalna_neto_zarada_po_satu' => str_replace(",", ".", $data['STOPA2']),
                'STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos' => str_replace(",", ".",$data['STOPA6']),
                'P1_stopa_poreza' => str_replace(",", ".",$data['P1']),
                'STOPA1_koeficijent_za_obracun_neto_na_bruto' => (float) str_replace(",", "",preg_replace('/,/','.',$data['STOPA1'],1)),
                'NT2_minimalna_bruto_zarada' => str_replace(",", ".",$data['NT2'])
//                'NT3_najniza_osnovica_za_placanje_doprinos' => str_replace(",", ".",$data['NT3']),
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/novo/DNTO.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

}
