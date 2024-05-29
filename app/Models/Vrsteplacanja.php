<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vrsteplacanja extends Model
{
    use HasFactory;

    protected $fillable = [
        'rbvp_sifra_vrste_placanja',
        'naziv_naziv_vrste_placanja',
        'formula_formula_za_obracun',
        'redosled_poentaza_zaglavlje',
        'redosled_poentaza_opis',
        'SLOV_grupe_vrsta_placanja',
        'POK1_grupisanje_sati_novca',
        'POK2_obracun_minulog_rada',
        'POK3_prikaz_kroz_unos',
        'KESC_prihod_rashod_tip',
        'EFSA_efektivni_sati',
        'PRKV_prosek_po_kvalifikacijama',
        'OGRAN_ogranicenje_za_minimalac',
        'PROSEK_prosecni_obracun',
        'VARI_minuli_rad',
        'DOVP_tip_vrste_placanja',
        'PLAC',
        'KATEG_sumiranje_redova_poentaza'
    ];
}
