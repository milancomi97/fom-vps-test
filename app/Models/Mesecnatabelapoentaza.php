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
        'napomena',
        'status_poentaze'
    ];

    public function organizacionecelina()
    {
        return $this->belongsTo(Organizacioneceline::class,'organizaciona_celina_id');
    }
    public function maticnadatotekaradnika()
    {
        return $this->belongsTo(Maticnadatotekaradnika::class, 'user_mdr_id');
    }

    public function dpsmakontacije()
    {
        // $related , $foreignKey = null, $localKey = null)
        return $this->hasOne(DpsmAkontacije::class,'user_dpsm_id');
    }
}
