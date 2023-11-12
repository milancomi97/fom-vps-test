<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Porezdoprinosi extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesec',
        'godina',
        'opis0_opis_iznos_poreskog_oslobadjanja',
        'izn1_iznos_poreskog_oslobadjanja',
        'oppor_opis_poreza',
        'p1_porez',
        'opis1_opis_zdravstvenog_osiguranja_na_teret_radnika',
        'zdro_zdravstveno_osiguranje_na_teret_radnika',
        'opis2_opis_pio_na_teret_radnika',
        'pio_pio_na_teret_radnika',
        'opis3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika',
        'onez_osiguranje_od_nezaposlenosti_na_teret_radnika',
        'ukdop_ukupni_doprinosi_na_teret_radnika',
        'opis4_opis_zdravstvenog_osiguranja_na_teret_poslodavca',
        'dopzp_zdravstveno_osiguranje_na_teret_poslodavca',
        'opis5_opis_pio_na_teret_poslodavca',
        'dopp_pio_na_teret_poslodavca',
        'ukdopp_ukupni_doprinosi_na_teret_poslodavca'
    ];
}
