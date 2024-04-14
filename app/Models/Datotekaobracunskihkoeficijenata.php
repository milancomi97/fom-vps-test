<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datotekaobracunskihkoeficijenata extends Model
{
    use HasFactory;

    protected $fillable = [
        'datum',
        'status',
        'kalendarski_broj_dana',
        'prosecni_godisnji_fond_sati',
        'mesecni_fond_sati',
        'mesecni_fond_sati_praznika',
        'cena_rada_tekuci',
        'cena_rada_prethodni',
        'tip_todo',
        'period_isplate_od',
        'period_isplate_do',
        'vrednost_akontacije',
        'mesec',
        'godina'
    ];
}
