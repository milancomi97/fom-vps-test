<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kartice extends Model
{
    use HasFactory;
    protected $fillable = ['sd', 'idbr', 'poz', 'magacin_id', 'materijal_id', 'datum_k', 'datum_d', 'kolicina', 'vrednost', 'cena', 'konto', 'tc', 'poru', 'norma', 'veza', 'mesec', 'nal1', 'nal2', 'gru'];
    // Relacija prema dokumentima
    public function dokument()
    {
        return $this->belongsTo(DokumentSifarnik::class, 'sd', 'sd');
    }

    // Relacija prema materijalima
    public function materijal()
    {
        return $this->belongsTo(Materijal::class, 'materijal_id', 'sifra_materijala');
    }

    // Relacija prema magacinima
    public function magacin()
    {
        return $this->belongsTo(Magacin::class, 'magacin_id');
    }
}
