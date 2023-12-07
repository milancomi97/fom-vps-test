<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesecnatabelapoentaza extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizaciona_celina_id',
        'vrste_placanja',
        'user_id',
        'datum',
        'maticni_broj',
        'ime',
        'prezime'
    ];
}
