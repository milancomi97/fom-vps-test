<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ArhivaSumeZaraPoRadnikuSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();
//        ;;;;;;;;;;
//;;;;;;;;;;
//;;;;;;;;;;
//;;;;;;;;;;
//;;;;;;;;;;
//;;;;;;;;;;;;
//;;;;;;;;;;;;;
// TODO SKINULI PIOR1;ZDRR1;ONEZR1;PIOP1;ZDRP1;ONEZP1;BROSN1;POROSL1;SIP1;IZNETO1;N

        // todo UKKONTR, SIZN, IZBRUTO,POREZ1,POREZ2,IZBRPR,IZBRBOL

        // todo SIPPR, SIPBOL, SIP_D, POSPOR, IZNETO2,AK,NRAKON,VAKON,UKNETO
        // todo KOEF, RBTC, UKIS, UKSIOB,UKZARKR,UKAKONT,UKNRAKON
        // todo DEO1, REC, HKMB, IZBRBO1, SIN,RAD2;RAD3;RAD4,VISP
        // todo OSNOV, DEOIM, IZN2, BROJ, MRBTC, GOD_30, GOD_50
        // todo ONEZP, SOP,DBEN, UKUPNO1
        foreach ($datas as $data) {
            $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);


            DB::table('arhiva_sume_zara_po_radnikus')->insert([
                'M_G_mesec_godina' =>$data['M_G'],
                'M_G_date' =>$date->format('Y-m-d'),
                'rbim_sifra_isplatnog_mesta' =>$data['RBIM'],
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
//                'ZRAC_tekuci_racun' =>$data['DATAAA'],
//                'POROSL1_poresko_oslobodjenje_za_prvu_isplatu' =>$data['DATAAA'],
//                'PIOR1_penzijsko_osiguranje_radnik_prva_isplata' =>$data['DATAAA'],
//                'PIOP1_penzijsko_osiguranje_poslodavac_prva_isplata' =>$data['DATAAA'],
//                'ZDRR1_zdravstveno_osig_radnik_prva_isplata' =>$data['DATAAA'],
//                'ZDRP1_zdravstveno_osig_poslodavac_prva_isplata' =>$data['DATAAA'],
//                'ONEZR1_osiguranje_od_nezaposlenosti_radnik' =>$data['DATAAA'],
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

    }



    public function getDataFromCsv()
    {
        $filePath = storage_path('app/backup/arhiva/SUME.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }
}
