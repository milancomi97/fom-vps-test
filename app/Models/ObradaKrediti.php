<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObradaKrediti extends Model
{
    use HasFactory;

    protected $fillable = [
        'maticni_broj',
        'sifra_vrste_placanja',
        'naziv_vrste_placanja',
        'SIFK_sifra_kreditora',
        'PART_partija_kredita',
        'KESC_prihod_rashod_tip',
        'GLAVN_glavnica',
        'SALD_saldo',
        'RATA_rata',
        'POCE_pocetak_zaduzenja',
        'RATP_prethodna',
        'STSALD_Prethodni_saldo',
        'DATUM_zaduzenja',
        'obracunski_koef_id',
        'user_mdr_id',
        'RBZA',
        'RATB',
        'iznos'
    ];
}
