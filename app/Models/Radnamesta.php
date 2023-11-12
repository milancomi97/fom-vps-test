<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radnamesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'rbrm_sifra_radnog_mesta',
        'narm_naziv_radnog_mesta',
        'status_active',
        'dident_datum_otvaranja_sifre',
        'dclose_datum_zatvaranja_sifre'
    ];
}
