<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'osnovni_podaci',
        'finansijsko_k',
        'materijalno_k',
        'pogonsko',
        'magacini',
        'osnovna_sredstva',
        'kadrovska_evidencija',
        'obracun_zarada',
        'tehnologija',
        'proizvodnja',
        'role_id',
//        'direktor_id', TODO
        'user_id',
        'troskovna_mesta_poenter',
        'user_permissions_id'
    ];
}
