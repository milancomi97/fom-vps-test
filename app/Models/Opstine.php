<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opstine extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifra_opstine',
        'naziv_opstine',
        'sifra_drzave'
    ];
}
