<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObradaDkopSveVrstePlacanja extends Model
{
    use HasFactory;

    protected $fillable = [
        'maticni_broj',
        'sifra_vrste_placanja',
        'naziv_vrste_placanja',
        'SLOV_grupa_vrste_placanja',
        'sati',
        'iznos',
        'procenat',
        'SALD_saldo',
        'POK2_obracun_minulog_rada',
        'KOEF_osnovna_zarada',
        'RBRM_radno_mesto',
        'KESC_prihod_rashod_tip',
        'P_R_oblik_rada',
        'RBIM_isplatno_mesto_id',
        'troskovno_mesto_id',
        'organizaciona_celina_id',
        'SIFK_sifra_kreditora',
        'STSALD_Prethodni_saldo',
        'NEAK_neopravdana_akontacija',
        'PART_partija_kredita',
        'POROSL_poresko_oslobodjenje',
        'obracunski_koef_id',
        'user_dpsm_id',
        'user_mdr_id',
        'tip_unosa',
        'kredit_glavna_tabela_id'
    ];

    public function maticnadatotekaradnika()
    {
        return $this->belongsTo(Maticnadatotekaradnika::class, 'user_mdr_id');
    }
}
