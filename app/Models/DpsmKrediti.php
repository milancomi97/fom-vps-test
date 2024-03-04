<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpsmKrediti extends Model
{
    use HasFactory;

    protected $fillable = [
        'maticni_broj',
        'SIFK_sifra_kreditora',
        'IMEK_naziv_kreditora',
        'PART_partija_poziv_na_broj',
        'GLAVN_glavnica',
        'SALD_saldo',
        'RATA_rata',
        'POCE_pocetak_zaduzenja',
        'DATUM_zaduzenja',
        'obracunski_koef_id',
        'user_dpsm_id'
    ];
}
