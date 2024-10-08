<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strucnakvalifikacija extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifra_kvalifikacije',
        'naziv_kvalifikacije',
        'skraceni_naziv_kvalifikacije'
    ];
}
