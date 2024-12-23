<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ArhivaMaticnadatotekaradnikaSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();
//        MBRD;M_G;RBRM;RBIM;ZRAC;P_R;BRCL;MRAD;GGST;MMST;
//KOEF;KOEF1;RBSS;RBPS;RBOP;;LBG;PREB;KP;RBTC;
//;;;;;POL;
//KFAK;PRIZ;PRCAS;BROJ;DANI;IZNETO1;POROSL1;SIP1;
//BROSN1;;;ZDRR1;ZDRP1;ONEZR1;ULICA;MESTO;
//PIOR;ZDRR;ONEZR;PIOP;ZDRP;BROSN;POROSL;SIP;IZNETO

        // TODO RBMZ, KP, REC, PRPB, PRST,PRVA,RBUZ, POCDAT,ZAVDAT,RBZA,POPRED
        // TODO ZAVPRD, STIM, HKMB, DEOIM,PIOR1, PIOP1,ONEZP1
        // TODO NAIM,ONEZP
        foreach ($datas as $data) {
            $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);

            try{


            DB::table('arhiva_maticnadatotekaradnikas')->insert(
                $this->userExists([
                    'M_G_mesec_godina' =>$data['M_G'],
                    'M_G_date' =>$date->format('Y-m-d'),
                    'MBRD_maticni_broj' => $data['MBRD'],
//                    'PREZIME_prezime' => $data['PREZIME'],
//                    'IME_ime' => $data['IME'],
//                    'srednje_ime' => '',
                    'RBRM_radno_mesto' => $data['RBRM'] !== '' ? (int)$data['RBRM'] : 0,
                    'RBIM_isplatno_mesto_id' => $data['RBIM'] !== '' ? $data['RBIM'] : 0,
                    'ZRAC_tekuci_racun' => $data['ZRAC'],
                    'BRCL_redosled_poentazi' => $data['BRCL'] !== '' ? $data['BRCL'] : 9999,
//                    'BR_vrsta_rada' => $data['BR'],
                    'BR_vrsta_rada' => '1',
                    'P_R_oblik_rada' => $data['P_R'],
//                    'RJ_radna_jedinica' => $data['RJ'], // TODO PROVERITI ZASTO NEMA
//                    'BRIG_brigada' => $data['BRIG'],// TODO PROVERITI ZASTO NEMA
                    'GGST_godine_staza' => $data['GGST'],
                    'MMST_meseci_staza' => $data['MMST'],
                    'MRAD_minuli_rad_aktivan' => $data['MRAD'] == "D",
                    'PREB_prebacaj' => $data['PREB'],
                    'RBSS_stvarna_strucna_sprema' => $data['RBSS'],
                    'RBPS_priznata_strucna_sprema' => $data['RBPS'],
                    'KOEF_osnovna_zarada' => $data['KOEF'] !== '' ? $data['KOEF'] : 0,
                    'KOEF1_prethodna_osnovna_zarada' => $data['KOEF1'] !== '' ? $data['KOEF1'] : 0,
                    'LBG_jmbg' => $data['LBG'],
                    'POL_pol' => $data['POL'],
                    'PRCAS_ukupni_sati_za_ukupan_bruto_iznost' => $data['PRCAS'],
                    'PRIZ_ukupan_bruto_iznos' => $data['PRIZ'],
                    'BROJ_broj_meseci_za_obracun' => $data['BROJ'],
                    'DANI_kalendarski_dani' => $data['DANI'],
                    'IZNETO1_bruto_zarada_za_akontaciju' => $data['IZNETO1'] !== '' ? $data['IZNETO1'] : 0,
                    'POROSL1_poresko_oslobodjenje_za_akontaciju' => $data['POROSL1'] !== '' ? $data['POROSL1'] : 0,
                    'SIP1_porez_za_akontaciju' => $data['SIP1'] !== '' ? $data['SIP1'] : 0,
                    'BROSN1_minimalna_osnovica_za_obracun_doprinosa_za_akontaciju' => $data['BROSN1'] !== '' ? $data['BROSN1'] : 0,
                    'ZDRR1_zdravstveno_osiguranje_na_teret_radnika_za_akontaciju' => $data['ZDRR1'] !== '' ? $data['ZDRR1'] : 0,
                    'ZDRP1_zdravstveno_osiguranje_na_teret_poslodavca_za_akontaciju' => $data['ZDRP1'] !== '' ? $data['ZDRP1'] : 0,
                    'ONEZR1_osig_nezaposlenosti_na_teret_radnika_za_akontaciju' => $data['ONEZR1'] !== '' ? $data['ONEZR1'] : 0,
                    'PIOR_ukupni_pio_doprinos_na_teret_radnika' => $data['PIOR'] !== '' ? $data['PIOR'] : 0,
                    'PIOP_ukupni_pio_doprinos_na_teret_poslodavca' => $data['PIOP'] !== '' ? $data['PIOP'] : 0,
                    'ONEZR_ukupni_doprinos_za_nezaposlenost_na_teret_radnika' => $data['ONEZR'] !== '' ? $data['ONEZR'] : 0,
                    'ZDRR_ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_radnika' => $data['ZDRR'] !== '' ? $data['ZDRR'] : 0,
                    'ZDRP_ukupni_doprinos_zdrav_osig_teret_poslodavca' => $data['ZDRP'] !== '' ? $data['ZDRP'] : 0,
                    'BROSN_bruto_zarada_za_obracun_doprinosa' => $data['BROSN'] !== '' ? $data['BROSN'] : 0,
                    'POROSL_ukupno_poresko_oslobodjenje' => $data['POROSL'] !== '' ? $data['POROSL'] : 0,
                    'SIP_ukupni_porezi' => $data['SIP'] !== '' ? $data['SIP'] : 0,
//                    'ACTIVE_aktivan' => $data['ACTIVE'] == 'TRUE', // TODO proveriti
                    'IZNETO_ukupna_bruto_zarada' => $data['IZNETO'] !== '' ? $data['IZNETO'] : 0,
                    'KFAK_korektivni_faktor' => $data['KFAK'] !== '' ? $data['KFAK'] : 0,
                    'troskovno_mesto_id' => $data['RBTC'] !== '' ? $data['RBTC'] : 0,
                    'opstina_id' => $data['RBOP'] !== '' ? $data['RBOP'] : null,
                    'adresa_ulica_broj' => $data['ULICA'],
                    'adresa_mesto' => $data['MESTO']

                ]));

            } catch (\Exception $e) {
                var_dump("Failed to create payment record for MBRD: ".json_encode($data).", Error: " . $e->getMessage());
            }
        }

    }

    private function updateUserId($maticniBroj)
    {
        $user = User::where('maticni_broj', $maticniBroj)->get();
        if (isset($user[0])) {
            $id = $user[0]->id;
        }
        return $id ?? 0;
    }

    private function userExists($data)
    {
//        $user = User::where('maticni_broj', $data['MBRD_maticni_broj'])->get();
//        if (isset($user[0])) {
//
//            $data['user_id'] = $user[0]->id;
//
//            if ($data['IME_ime'] == '') {
//                $data['IME_ime'] = $user[0]->ime;
//                $data['srednje_ime'] = $user[0]->srednje_ime;
//            }
//
//            if ($data['PREZIME_prezime'] == '') {
//                $data['PREZIME_prezime'] = $user[0]->prezime;
//                $data['srednje_ime'] = $user[0]->srednje_ime;
//
//            }
//
//            return $data;
//        }
        return $data;

    }

    public function getDataFromCsv()
    {
        $filePath = storage_path('app/backup/mts_server_priprema_14_10_2024/ARMD.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();

    }
}
