<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Porudzbine extends Model
{
    use HasFactory;
    protected $fillable = ['rbpo', 'napo', 'mbkom', 'dident', 'dclose', 'ugovor'];

    // Relacija prema materijalima (ako je potrebno)
    public function materijali()
    {
        return $this->belongsToMany(Materijal::class, 'porudzbina_materijal', 'porudzbina_id', 'materijal_id');
    }
}
