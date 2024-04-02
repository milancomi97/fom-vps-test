<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podaciofirmi extends Model
{
    use HasFactory;

    protected $fillable = [
        'naziv_firme',
        'poslovno_ime',
        'skraceni_naziv_firme',
        'status',
        'pravna_forma',
        'maticni_broj',
        'datum_osnivanja',
        'adresa_sedista',
        'opstina_id',
        'ulica_broj_slovo',
        'broj_poste',
        'pib',
        'sifra_delatnosti',
        'naziv_delatnosti',
        'racuni_u_bankama',
        'adresa_za_prijem_poste',
        'adresa_za_prijem_elektronske_poste',
        'telefon',
        'internet_adresa',
        'zakonski_zastupnik_ime_prezime',
        'zakonski_zastupnik_funkcija',
        'zakonski_zastupnik_jmbg',
        'obaveznik_revizije',
        'velicina_po_razvrstavanju',
        'minulirad_aktivan',
        'minulirad'
    ];
}
