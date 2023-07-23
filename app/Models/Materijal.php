<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materijal extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sifra_materijala',
        'naziv_materijala',
        'standard',
        'dimenzija',
        'kvalitet',
        'jedinica_mere',
        'tezina',
        'dimenzije',
        'dimenzija_1',
        'dimenzija_2',
        'dimenzija_3',
        'sifra_standarda',
        'napomena'
    ];
}
