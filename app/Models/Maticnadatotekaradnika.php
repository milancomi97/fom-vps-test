<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maticnadatotekaradnika extends Model
{
    use HasFactory;

    protected $fillable = [
        'maticni_broj',
        'prezime',
        'ime',
        'radno_mesto',
        'isplatno_mesto',
        'tekuci_racun',
        'redosled_poentazi',
        'vrsta_rada',
        'RJ_radna_jedinica',
        'BRIG_brigada',
        'godine',
        'meseci',
        'minuli_rad_aktivan',
        'stvarna_strucna_sprema',
        'priznata_strucna_sprema',
        'osnovna_zarada',
        'jmbg',
        'pol_muski',
        'prosecni_sati',
        'prosecna_zarada',
        'adresa_ulica_broj',
        'opstina_id',
        'user_id'
    ];

    public function mesecnatabelapoentaza()
    {
        return $this->hasOne(Mesecnatabelapoentaza::class);
    }
}
