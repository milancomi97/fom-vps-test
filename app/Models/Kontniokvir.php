<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontniokvir extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifra_konta',
        'naziv_konta',
        'vrsta_analitickog_konta',
        'pdv',
        'pogonsko',
        'direktna_raspodela',
        'indirektna_raspodela',
        'procenat_preracuna_za_troskove_reklame',
        'klasa_9',
        'bilans_stanja_aop',
        'bilans_stanja_formula',
        'bilans_uspeha_aop',
        'bilans_uspeha_formula',
        'statisticki_izvestaj_aop',
        'statisticki_izvestaj_formula',
        'izvestaj_o_ostalom_rezultatu_aop',
        'izvestaj_o_ostalom_rezultatu_formula',
        'izvestaj_o_tokovima_gotovine_aop',
        'izvestaj_o_tokovima_gotovine_formula',
        'posebni_podaci_aop',
        'posebni_podaci_formula'
    ];

}
