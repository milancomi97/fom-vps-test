<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drzave extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifra_drzave',
        'naziv_drzave',
        'oznaka_drzave',
        'oznaka_valute',
        'opis_valute'
    ];
}
