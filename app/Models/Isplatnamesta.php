<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isplatnamesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'rbim_sifra_isplatnog_mesta',
        'naim_naziv_isplatnog_mesta',
        'tekuci_racun_banke',
        'pb_poziv_na_broj',
        'partija_racuna'
    ];

    // SIFRA FIRME_u_banci
    // OPIS Priliva
    // sifra_banke
    // poziv_na_broj
}
