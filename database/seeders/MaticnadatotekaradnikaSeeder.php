<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class MaticnadatotekaradnikaSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('maticnadatotekaradnikas')->insert(
                $this->userExists([
                'MBRD_maticni_broj' => $data['MBRD'],
                'PREZIME_prezime' => $data['PREZIME'],
                'IME_ime' => $data['IME'],
                'RBRM_radno_mesto' => $data['RBRM'],
                'RBIM_isplatno_mesto_id' => $data['RBIM'],
                'ZRAC_tekuci_racun' => $data['ZRAC'],
                'BRCL_redosled_poentazi' => $data['BRCL'],
                'BR_vrsta_rada' => $data['BR'],
                'P_R_oblik_rada' => $data['P_R'],
                'RJ_radna_jedinica' => $data['RJ'],
                'BRIG_brigada' => $data['BRIG'],
                'GGST_godine_staza' => $data['GGST'],
                'MMST_meseci_staza' => $data['MMST'],
                'MRAD_minuli_rad_aktivan' => $data['MRAD'] =="D",
                'PREB_prebacaj' => $data['PREB'],
                'RBSS_stvarna_strucna_sprema' =>(int) $data['RBSS'],
                'RBPS_priznata_strucna_sprema' =>(int) $data['RBPS'],
                'KOEF_osnovna_zarada' => $data['KOEF'],
                'KOEF1_prethodna_osnovna_zarada' => $data['KOEF1'],
                'LBG_jmbg' => $data['LBG'],
                'POL_pol' => $data['POL'],
                'PRCAS_ukupni_sati_za_ukupan_bruto_iznost' => $data['PRCAS'],
                'PRIZ_ukupan_bruto_iznos' => $data['PRIZ'],
                'BROJ_broj_meseci_za_obracun' => $data['BROJ'],
                'DANI_kalendarski_dani' => $data['DANI'],
                'IZNETO1_bruto_zarada_za_akontaciju' => $data['IZNETO1'],
                'POROSL1_poresko_oslobodjenje_za_akontaciju' => $data['POROSL1'],
                'SIP1_porez_za_akontaciju' => $data['SIP1'],
                'BROSN1_minimalna_osnovica_za_obracun_doprinosa_za_akontaciju' => $data['BROSN1'],
                'ZDRR1_zdravstveno_osiguranje_na_teret_radnika_za_akontaciju' => $data['ZDRR1'],
                'ZDRP1_zdravstveno_osiguranje_na_teret_poslodavca_za_akontaciju' => $data['ZDRP1'],
                'ONEZR1_osig_nezaposlenosti_na_teret_radnika_za_akontaciju' => $data['ONEZR1'],
                'PIOR_ukupni_pio_doprinos_na_teret_radnika' => $data['PIOR'],
                'PIOP_ukupni_pio_doprinos_na_teret_poslodavca' => $data['PIOP'],
                'ONEZR_ukupni_doprinos_za_nezaposlenost_na_teret_radnika' => $data['ONEZR'],
                'ZDRR_ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_radnika' => $data['ZDRR'],
                'ZDRP_ukupni_doprinos_zdrav_osig_teret_poslodavca' => $data['ZDRP'],
                'BROSN_bruto_zarada_za_obracun_doprinosa' => $data['BROSN'],
                'POROSL_ukupno_poresko_oslobodjenje' => $data['POROSL'],
                'SIP_ukupni_porezi' => $data['SIP'],
                'ACTIVE_aktivan' => $data['ACTIVE'] == 'TRUE',
                'IZNETO_ukupna_bruto_zarada' => $data['IZNETO'],
                'KFAK_korektivni_faktor' => $data['KFAK'],
//                'opstina_id' => $data['testtt'],
                'troskovno_mesto_id' => (int) $data['RBTC']

            ]));
        }

    }

    private function updateUserId($maticniBroj){
       $user = User::where('maticni_broj',$maticniBroj)->get();
     if(isset($user[0])) {
        $id = $user[0]->id;
     }
     return $id ?? 0;
    }
    private function userExists($data){
        $user = User::where('maticni_broj',$data['MBRD_maticni_broj'])->get();
        if(isset($user[0])){

            var_dump($user[0]->id);
            $data['user_id'] =  $user[0]->id;
            return $data;
        }
        return $data;

    }
    public function getDataFromCsv()
    {
        $filePath = storage_path('app/backup/MDR_3.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }
}
