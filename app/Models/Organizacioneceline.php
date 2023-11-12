<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizacioneceline extends Model
{
    use HasFactory;

    protected $fillable = [
        'sifra_troskovnog_mesta',
        'naziv_troskovnog_mesta'
    ];
}
