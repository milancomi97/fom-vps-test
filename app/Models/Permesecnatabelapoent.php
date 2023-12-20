<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permesecnatabelapoent extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizaciona_celina_id',
        'obracunski_koef_id',
        'status',
        'poenteri_ids',
        'poenteri_status',
        'odgovorna_lica_ids',
        'odgovorna_lica_status',
        'datum'
    ];
}

