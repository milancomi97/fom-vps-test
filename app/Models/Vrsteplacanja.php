<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vrsteplacanja extends Model
{
    use HasFactory;

    protected $fillable = [
        'rbvp_sifra_vrste_placanja',
        'naziv_naziv_vrste_placanja',
        'formula_formula_za_obracun'
    ];
}
