<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpsmFiksnaPlacanja extends Model
{
    use HasFactory;

    protected $fillable = [
        'maticni_broj',
        'sifra_vrste_placanja',
        'naziv_vrste_placanja',
        'SLOV_grupa_vrste_placanja',
        'sati',
        'iznos',
        'procenat',
        'status',
        'POK2_obracun_minulog_rada',
        'datum',
        'obracunski_koef_id',
        'user_dpsm_id',
        'user_mdr_id'
    ];

    public function maticnadatotekaradnika()
    {
        return $this->belongsTo(Maticnadatotekaradnika::class, 'user_mdr_id');
    }
}
