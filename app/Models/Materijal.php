<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materijal extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifra_materijala',
        'category_id',
        'sifra_materijala',
        'naziv_materijala',
        'standard',
        'dimenzija',
        'kvalitet',
        'jedinica_mere',
        'tezina',
        'dimenzije',
        'dimenzija_1_value',
        'dimenzija_1',
        'dimenzija_2_value',
        'dimenzija_2',
        'dimenzija_3_value',
        'konto',
        'sifra_standarda',
        'napomena'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stanjematerijala()
    {
        return $this->hasMany(StanjeZaliha::class, 'sifra_materijala','sifra_materijala');
    }


}
