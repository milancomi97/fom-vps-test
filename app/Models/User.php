<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'interni_maticni_broj',
        'ime',
        'prezime',
        'srednje_ime',
        'slika_zaposlenog',
        'maticni_broj',
        'troskovno_mesto',
        'active',
        'email',
        'jmbg',
        'email_verified_at',
        'password',
        'telefon_poslovni',
        'licna_karta_broj_mesto_rodjenja',
        'adresa_ulica_broj',
        'opstina_id',
        'drzava_id',
        'sifra_mesta_troska_id',
        'status_ugovor_id',
        'datum_zasnivanja_radnog_odnosa',
        'datum_prestanka_radnog_odnosa',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissionOne()
    {
        return $this->hasOne(UserPermission::class, 'user_id','id' );
    }

    public function permission()
    {
        return $this->belongsTo(UserPermission::class, 'id', 'user_id');
    }

    public function maticnadatotekaradnika()
    {
        return $this->hasOne(Maticnadatotekaradnika::class, 'user_id', 'id');
    }
}
