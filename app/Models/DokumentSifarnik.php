<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentSifarnik extends Model
{
    use HasFactory;
    protected $fillable = ['sd', 'dokument', 'vred'];
    // Relacija prema karticama
    public function kartice()
    {
        return $this->hasMany(Kartica::class, 'sd', 'sd');
    }
}
