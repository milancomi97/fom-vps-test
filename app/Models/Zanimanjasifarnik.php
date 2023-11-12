<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zanimanjasifarnik extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifra_zanimanja',
        'naziv_zanimanja'
    ];
}
