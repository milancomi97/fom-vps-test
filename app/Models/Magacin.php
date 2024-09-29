<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magacin extends Model
{
    use HasFactory;
    protected $fillable = ['sm','name', 'location'];

    public function stanjeZaliha()
    {
        return $this->hasMany(StanjeZaliha::class, 'magacin_id');
    }
}
