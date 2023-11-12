<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kreditori extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifk_sifra_kreditora',
        'imek_naziv_kreditora',
        'sediste_kreditora',
        'tekuci_racun_za_uplatu',
        'partija_kredita'
    ];
}
