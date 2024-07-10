<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minimalnebrutoosnovice extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesec',
        'godina',
        'M_G_mesec_dodina',
        'M_G_date',
        'nt1_prosecna_mesecna_osnovica',
        'stopa2_minimalna_neto_zarada_po_satu',
        'stopa6_koeficijent_najvise_osnovice_za_obracun_doprinos',
        'p1_stopa_poreza',
        'stopa1_koeficijent_za_obracun_neto_na_bruto',
        'nt3_najniza_osnovica_za_placanje_doprinos',
        'nt2_minimalna_bruto_zarada'
    ];
}
