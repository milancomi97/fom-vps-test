<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StanjeZaliha extends Model
{
    use HasFactory;


    protected $fillable = [
        'magacin_id', 'sifra_materijala', 'konto', 'cena', 'kolicina', 'vrednost',
        'pocst_kolicina', 'pocst_vrednost', 'ulaz_kolicina', 'ulaz_vrednost',
        'izlaz_kolicina', 'izlaz_vrednost', 'stanje_kolicina', 'stanje_vrednost', 'st_mag'
    ];

    // Relacija prema Materijal modelu
    public function materijal()
    {
        return $this->belongsTo(Materijal::class, 'sifra_materijala', 'sifra_materijala');
    }

    // Relacija prema Magacin modelu
    public function magacin()
    {
        return $this->belongsTo(Magacin::class, 'magacin_id');
    }
}
