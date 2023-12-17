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
        'prezime',
        'srednje_ime',
        'ime',
        'napomena'
    ];

    public function organizacionecelina()
    {
        return $this->belongsTo(Organizacioneceline::class,'organizaciona_celina_id');
    }

}
