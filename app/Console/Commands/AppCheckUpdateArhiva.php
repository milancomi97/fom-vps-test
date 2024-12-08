<?php

namespace App\Console\Commands;

use App\Models\ArhivaDarhObradaSveDkop;
use App\Models\ArhivaMaticnadatotekaradnika;
use App\Models\ArhivaSumeZaraPoRadniku;
use App\Models\DpsmKrediti;
use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppCheckUpdateArhiva extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updateArhiva';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Komanda koja proverava projekat';

    /**
     * Execute the console command.
     */
    public function __construct(
        private readonly VrsteplacanjaRepositoryInterface          $vrsteplacanjaInterface,

    ){
        parent::__construct();
    }




    public function handle()
    {

//        $mdrData = $this->getMdrData();
        ArhivaDarhObradaSveDkop::truncate();
        ArhivaSumeZaraPoRadniku::truncate();
        ArhivaMaticnadatotekaradnika::truncate();

        $datas = $this->getDataFromCsvSume();

        // todo IZBRPR,IZBRBOL
        // dodaj kao pomocne
        // DODAJ UKNETO
        // UKIS_ukupan_iznos_za_izplatu = UKIS
        // RBTC - troskovni centar
        // DEO1,- isplata iz dva puta
        // onezp - ONEZP_osiguranje_od_nezaposlenosti_teret_poslodavca
        // SOP- sifra opstine

        foreach ($datas as $data) {
            $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);

                DB::table('arhiva_sume_zara_po_radnikus')->insert([
                    'M_G_mesec_godina' =>$data['M_G'],
                    'M_G_date' =>$date->format('Y-m-d'),
                    'rbim_sifra_isplatnog_mesta' =>$data['RBIM'] !== '' ? $data['RBIM'] : 0,
                    'maticni_broj' =>$data['MBRD'],
//                'sifra_troskovnog_mesta' =>$data['DATAAA'],
                    'SSZNE_suma_sati_zarade' =>$data['SSZNE'],
                    'SIZNE_ukupni_iznos_zarade' =>$data['SIZNE'],
                    'SSNNE_suma_sati_naknade' =>$data['SSNNE'],
                    'SINNE_ukupni_iznos_naknade' =>$data['SINNE'],
                    'IZNETO_zbir_ukupni_iznos_naknade_i_naknade' =>$data['IZNETO'],
                    'SID_ukupni_iznos_doprinosa' =>$data['SID'],
                    'SIP_ukupni_iznos_poreza' =>$data['SIP'],
                    'SIOB_ukupni_iznos_obustava' =>$data['SIOB'],
                    'EFSATI_ukupni_iznos_efektivnih_sati' =>$data['EFSATI'],
                    'AKONT_iznos_primljene_akontacije' =>$data['AKONT'],
                    'NEAK_neopravdana_akontacija' =>$data['NEAK'],
                    'ZARKR_ukupni_zbir_kredita' =>$data['ZARKR'],
                    'EFIZNO_kumulativ_iznosa_za_efektivne_sate' =>$data['EFIZNO'] !== '' ? $data['EFIZNO'] : 0,
                    'RBPS_strucna_sprema' =>$data['RBPS'],
                    'MINIM_minimalna_zarada' =>$data['MINIM'],
//                'RBOP_sifra_opstine' =>$data['DATAAA'],
//                'TOPLI_obrok_iznos' =>$data['DATAAA'],
//                'TOPLI_obrok_sati' =>$data['DATAAA'],
                    'PRIZ_prosecni_iznos_godina' =>$data['PRIZ'],
                    'PRCAS_prosecni_sati_godina' =>$data['PRCAS'],
//                'KOREKC_dotacija_za_minimalnu_bruno_osnovicu' =>$data['DATAAA'],
//                'REGRES_iznos_regresa' =>$data['DATAAA'],
                    'POROSL_poresko_oslobodjenje' =>$data['POROSL'],
//                'ime' =>$data['DATAAA'],
//                'prezime' =>$data['DATAAA'],
//                'srednje_ime' =>$data['DATAAA'],
//                'LBG_jmbg' =>$data['DATAAA'],
//                'GGST_godine_staza' =>$data['DATAAA'],
//                'MMST_meseci_staza' =>$data['DATAAA'],
//                'RBRM_redni_broj_radnog_mesta' =>$data['DATAAA'],
                    'NETO_neto_zarada' =>$data['NETO'],
//                'IZNETO1_prva_isplata_akontacija' =>$data['DATAAA'],
//                'SIP1_porez_prva_isplata' =>$data['DATAAA'],
                    'BROSN_osnovica_za_doprinose' =>$data['BROSN'],
//                'BROSN1_osnovica_za_doprinose_prva_isplata' =>$data['DATAAA'],
                    'PIOR_penzijsko_osiguranje_na_teret_radnika' =>$data['PIOR'],
                    'ZDRR_zdravstveno_osiguranje_na_teret_radnika' =>$data['ZDRR'],
                    'ONEZR_osiguranje_od_nezaposlenosti_teret_radnika' =>$data['ONEZR'],
                    'PIOP_penzijsko_osiguranje_na_teret_poslodavca' =>$data['PIOP'],
                    'ZDRP_zdravstveno_osiguranje_na_teret_poslodavca' =>$data['ZDRP'],
//                'UKSA_ukupni_sati_za_isplatu' =>$data['DATAAA'],
                    'olaksica' =>$data['OLAKSICA'],
//                'PREK_prekovremeni' =>$data['DATAAA'],
//                'obracunski_koef_id' =>$data['DATAAA'],
//                'user_dpsm_id' =>$data['DATAAA'],
//                'user_mdr_id' =>$data['DATAAA'],
//                'solid' =>$data['DATAAA'],
                    'ISPLATA' =>$data['ISPLATA'] !== '' ? $data['ISPLATA'] : 0,
                    'UKUPNO' =>$data['UKUPNO'],
//                'troskovno_mesto_id' =>$data['DATAAA'],
//                'organizaciona_celina_id' =>$data['DATAAA'],
//                'varijab' =>$data['DATAAA'],
                    'BMIN_prekovremeni_iznos' =>$data['BMIN'] !== '' ? $data['BMIN'] : 0,
                ]);

        }



        $datas = $this->getDataFromCsvMDR();
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


                DB::table('arhiva_maticnadatotekaradnikas')->insert(
                        ['M_G_mesec_godina' =>$data['M_G'],
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

                    ]);

        }





        $datas = $this->getDataFromCsvDarh();
        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();

        foreach ($datas as $data) {
            $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);

            DB::table('arhiva_darh_obrada_sve_dkops')->insert([
                'M_G_mesec_godina' => $data['M_G'],
                'M_G_date' => $date->format('Y-m-d'),
                'maticni_broj' => $data['MBRD'],
                'sifra_vrste_placanja' => $data['RBVP'],
                'naziv_vrste_placanja' => isset($sifarnikVrstePlacanja[$data['RBVP']]) ? $sifarnikVrstePlacanja[$data['RBVP']]['naziv_naziv_vrste_placanja'] : 'SIFRA NE POSTOJI U TRENUTNOM SIFARNIKU',
                'SLOV_grupa_vrste_placanja' => $data['SLOV'],
                'sati' => $data['SATI'],
                'iznos' => $data['IZNO'],
                'procenat' => $data['PERC'],
                'SALD_saldo' => $data['SALD'],
                'POK2_obracun_minulog_rada' => $data['POK2'],
                'KOEF_osnovna_zarada' => $data['KOEF'],
                'RBRM_radno_mesto' => $data['RBRM'],
                'KESC_prihod_rashod_tip' => $data['KESC'],
                'P_R_oblik_rada' => $data['P_R'],
                'SIFK_sifra_kreditora' => $data['SIFK'],
                'STSALD_Prethodni_saldo' => $data['STSALD'],
                'PART_partija_kredita' => $data['PART'],

            ]);
        }


    }



    public function getDataFromCsvSume()
    {
        $filePath = storage_path('app/backup/otvaranje_11_2024_datum_05_12_2024/SUME.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }


        public function getDataFromCsvMdr()
    {
        $filePath = storage_path('app/backup/otvaranje_11_2024_datum_05_12_2024/ARMD.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();

    }

    public function getDataFromCsvDarh()
    {
        $filePath = storage_path('app/backup/otvaranje_11_2024_datum_05_12_2024/DARH.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();

    }
}
