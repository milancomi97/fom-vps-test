<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vrstaradasifarnik extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifra_statusa',
        'naziv_statusa',
        'svp_sifra_vrste_placanja'
    ];
}
