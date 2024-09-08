<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class MinimalnebrutoosnoviceAvgustSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);


            DB::table('minimalnebrutoosnovices')->insert([
                'M_G_mesec_dodina' =>$data['M_G'],
                'M_G_date' =>$date->format('Y-m-d'),
                'NT1_prosecna_mesecna_zarada_u_republici' => (float) str_replace(",", ".",$data['NT1']),
                'STOPA2_minimalna_neto_zarada_po_satu' => (float) str_replace(",", ".", $data['STOPA2']),
                'STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos' => (float) str_replace(",", ".",$data['STOPA6']),
                'P1_stopa_poreza' => (float) str_replace(",", ".",$data['P1']),
                'STOPA1_koeficijent_za_obracun_neto_na_bruto' => (float) str_replace(",", "",preg_replace('/,/','.',$data['STOPA1'],1)),
                'NT2_minimalna_bruto_zarada' => (float) str_replace(",", ".",$data['NT2'])
//                'NT3_najniza_osnovica_za_placanje_doprinos' => str_replace(",", ".",$data['NT3']),
            ]);
        }

    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/avgustPlataNovo/DNTO.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

}
