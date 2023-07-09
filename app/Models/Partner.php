<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'contact_employee',
        'pib',
        'phone',
        'web_site',
        'email',
        'sifra_delatnosti',
        'odgovorno_lice',
        'maticni_broj',
        'registarski_broj',
        'mesto',
        'pripada_pdvu',
        'adress',
        'active',
        'internal_sifra'
    ];
}
