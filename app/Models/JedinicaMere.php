<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JedinicaMere extends Model
{
    use HasFactory;
    protected $fillable = ['oznaka', 'naziv'];

    public function materijals()
    {
        return $this->hasMany(Materijal::class, 'jedinica_mere', 'oznaka');
    }

}
