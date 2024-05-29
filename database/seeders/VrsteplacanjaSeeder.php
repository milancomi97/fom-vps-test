<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class VrsteplacanjaSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('vrsteplacanjas')->insert([
                'rbvp_sifra_vrste_placanja' => $data['RBVP'],
                'naziv_naziv_vrste_placanja' => $data['NAZI'],
                'formula_formula_za_obracun' => $data['BLOK'],
                'redosled_poentaza_zaglavlje' => $data['POEN'],
                'redosled_poentaza_opis' => $data['RIK'],
                'SLOV_grupe_vrsta_placanja' => $data['SLOV'],
                'POK1_grupisanje_sati_novca' => (int) $data['POK1'],
                'POK2_obracun_minulog_rada' => $data['POK2'],
                'POK3_prikaz_kroz_unos' => $data['POK3'],
                'KESC_prihod_rashod_tip' => $data['KESC'],
                'EFSA_efektivni_sati' => $data['EFSA'] =='TRUE',
                'PRKV_prosek_po_kvalifikacijama' => $data['PRKV'],
                'OGRAN_ogranicenje_za_minimalac' => $data['OGRAN'],
                'PROSEK_prosecni_obracun' =>(int) $data['PROSEK'],
                'VARI_minuli_rad' => $data['VARI'],
                'DOVP_tip_vrste_placanja' => $data['DOVP'] =='TRUE',
                'PLAC'=>$data['PLAC'],
                'KATEG_sumiranje_redova_poentaza'=>$data['KATEG']
            ]);
        }
    }

    public function getDataFromCsv(){
        $filePath = storage_path('app/backup/novo/DVPL_2.csv');
//        $filePath = storage_path('app/backup/DVPL4.csv');

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

}
