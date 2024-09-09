<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StanjeZaliha extends Model
{
    use HasFactory;

    protected $fillable = [
        'naziv_materijala',
        'sifra_materijala',
        'magacin_id',
        'standard',
        'dimenzija',
        'kvalitet',
        'jedinica_mere',
        'konto',
        'pocst_kolicina',
        'pocst_vrednost',
        'ulaz_kolicina',
        'ulaz_vrednost',
        'izlaz_kolicina',
        'izlaz_vrednost',
        'stanje_kolicina',
        'stanje_vrednost',
        'cena'
    ];


    public function material()
    {
        return $this->belongsTo(Materijal::class, 'sifra_materijala', 'sifra_materijala');
    }

    public function warehouse()
    {
        return $this->belongsTo(Magacin::class, 'magacin_id');
    }

}
