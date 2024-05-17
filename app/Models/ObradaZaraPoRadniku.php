<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObradaZaraPoRadniku extends Model
{
    use HasFactory;

    protected $fillable = [
        'rbim_sifra_isplatnog_mesta',
        'maticni_broj',
        'sifra_troskovnog_mesta',
        'SSZNE_suma_sati_zarade',
        'SIZNE_ukupni_iznos_zarade',
        'SSNNE_suma_sati_naknade',
        'SINNE_ukupni_iznos_naknade',
        'IZNETO_zbir_ukupni_iznos_naknade_i_naknade',
        'SID_ukupni_iznos_doprinosa',
        'SIP_ukupni_iznos_poreza',
        'SIOB_ukupni_iznos_obustava',
        'EFSATI_ukupni_iznos_efektivnih_sati',
        'AKONT_iznos_primljene_akontacije',
        'NEAK_neopravdana_akontacija',
        'ZARKR_ukupni_zbir_kredita',
        'EFIZNO_kumulativ_iznosa_za_efektivne_sate',
        'RBPS_strucna_sprema',
        'MINIM_minimalna_zarada',
        'RBOP_sifra_opstine',
        'TOPLI_obrok_iznos',
        'TOPLI_obrok_sati',
        'PRIZ_prosecni_iznos_godina',
        'PRCAS_prosecni_sati_godina',
        'KOREKC_dotacija_za_minimalnu_bruno_osnovicu',
        'REGRES_iznos_regresa',
        'POROSL_poresko_oslobodjenje',
        'ime',
        'prezime',
        'srednje_ime',
        'LBG_jmbg',
        'GGST_godine_staza',
        'MMST_meseci_staza',
        'RBRM_redni_broj_radnog_mesta',
        'NETO_neto_zarada',
        'IZNETO1_prva_isplata_akontacija',
        'SIP1_porez_prva_isplata',
        'BROSN_osnovica_za_doprinose',
        'BROSN1_osnovica_za_doprinose_prva_isplata',
        'PIOR_penzijsko_osiguranje_na_teret_radnika',
        'ZDRR_zdravstveno_osiguranje_na_teret_radnika',
        'ONEZR_osiguranje_od_nezaposlenosti_teret_radnika',
        'PIOP_penzijsko_osiguranje_na_teret_poslodavca',
        'ZDRP_zdravstveno_osiguranje_na_teret_poslodavca',
        'ZRAC_tekuci_racun',
        'POROSL1_poresko_oslobodjenje_za_prvu_isplatu',
        'PIOR1_penzijsko_osiguranje_radnik_prva_isplata',
        'PIOP1_penzijsko_osiguranje_poslodavac_prva_isplata',
        'ZDRR1_zdravstveno_osig_radnik_prva_isplata',
        'ZDRP1_zdravstveno_osig_poslodavac_prva_isplata',
        'ONEZR1_osiguranje_od_nezaposlenosti_radnik',
        'UKSA_ukupni_sati_za_isplatu',
        'olaksica',
        'PREK_prekovremeni',
        'obracunski_koef_id',
        'user_dpsm_id',
        'user_mdr_id',
        'solid',
        'ISPLATA',
        'UKUPNO',
        'troskovno_mesto_id',
        'organizaciona_celina_id'
    ];

}
