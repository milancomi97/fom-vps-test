<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpsmAkontacije extends Model
{
    use HasFactory;

    protected $fillable = [
        'maticni_broj',
        'sifra_vrste_placanja',
        'SLOV_grupa_vrste_placanja',
        'sati',
        'iznos',
        'procenat',
        'POK2_obracun_minulog_rada',
        'obracunski_koef_id',
        'user_dpsm_id'
    ];

}
