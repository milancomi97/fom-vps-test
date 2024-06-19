<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maticnadatotekaradnika extends Model
{
    use HasFactory;


    protected $fillable = [
        'maticni_broj',
        'prezime',
        'ime',
        'radno_mesto',
        'isplatno_mesto',
        'tekuci_racun',
        'redosled_poentazi',
        'vrsta_rada',
        'RJ_radna_jedinica',
        'BRIG_brigada',
        'godine',
        'meseci',
        'minuli_rad_aktivan',
        'stvarna_strucna_sprema',
        'priznata_strucna_sprema',
        'osnovna_zarada',
        'jmbg',
        'pol_muski',
        'prosecni_sati',
        'prosecna_zarada',
        'adresa_ulica_broj',
        'adresa_mesto',
        'opstina_id',
        'user_id',
        'MBRD_maticni_broj',
        'PREZIME_prezime',
        'IME_ime',
        'RBRM_radno_mesto',
        'RBIM_isplatno_mesto_id',
        'ZRAC_tekuci_racun',
        'BRCL_redosled_poentazi',
        'BR_vrsta_rada',
        'P_R_oblik_rada',
        'RJ_radna_jedinica',
        'BRIG_brigada',
        'GGST_godine_staza',
        'MMST_meseci_staza',
        'MRAD_minuli_rad_aktivan',
        'PREB_prebacaj',
        'DANI_kalendarski_dani',
        'RBSS_stvarna_strucna_sprema',
        'RBPS_priznata_strucna_sprema',
        'KOEF_osnovna_zarada',
        'KOEF1_prethodna_osnovna_zarada',
        'LBG_jmbg',
        'POL_pol',
        'PRCAS_ukupni_sati_za_ukupan_bruto_iznost',
        'PRIZ_ukupan_bruto_iznos',
        'BROJ_broj_meseci_za_obracun',
        'IZNETO1_bruto_zarada_za_akontaciju',
        'POROSL1_poresko_oslobodjenje_za_akontaciju',
        'SIP1_porez_za_akontaciju',
        'BROSN1_minimalna_osnovica_za_obracun_doprinosa_za_akontaciju',
        'ZDRR1_zdravstveno_osiguranje_na_teret_radnika_za_akontaciju',
        'ZDRP1_zdravstveno_osiguranje_na_teret_poslodavca_za_akontaciju',
        'ONEZR1_osig_nezaposlenosti_na_teret_radnika_za_akontaciju',
        'PIOR_ukupni_pio_doprinos_na_teret_radnika',
        'PIOP_ukupni_pio_doprinos_na_teret_poslodavca',
        'ONEZR_ukupni_doprinos_za_nezaposlenost_na_teret_radnika',
        'ZDRR_ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_radnika',
        'ZDRP_ukupni_doprinos_zdrav_osig_teret_poslodavca',
        'BROSN_bruto_zarada_za_obracun_doprinosa',
        'POROSL_ukupno_poresko_oslobodjenje',
        'SIP_ukupni_porezi',
        'ACTIVE_aktivan',
        'IZNETO_ukupna_bruto_zarada',
        'KFAK_korektivni_faktor',
        'troskovno_mesto_id'
    ];

    public function mesecnatabelapoentaza()
    {
        return $this->hasOne(Mesecnatabelapoentaza::class);
    }
}
