<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('interni_maticni_broj')->nullable();
            $table->string('ime')->nullable();
            $table->string('prezime')->nullable();
            $table->string('srednje_ime', 15)->nullable();
            $table->string('name')->nullable();
            $table->string('slika_zaposlenog', 255)->nullable();
            $table->string('datum_odlaska')->nullable();
            $table->string('maticni_broj')->nullable();
            $table->string('troskovno_mesto')->nullable();
            $table->boolean('active')->nullable();
            $table->string('email')->unique();
            $table->string('jmbg', 13)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('telefon_poslovni', 30)->nullable();
            $table->rememberToken();
            $table->string('licna_karta_broj_mesto_rodjenja', 40)->nullable();
            $table->string('adresa_ulica_broj', 50)->nullable();
            $table->unsignedBigInteger('opstina_id')->comment('Relacija opstine')->nullable();
            $table->unsignedBigInteger('drzava_id')->comment('Relacija drzava')->nullable();
            $table->unsignedBigInteger('sifra_mesta_troska_id')->comment('Relacija organizacione jedinice')->nullable();
            $table->unsignedBigInteger('status_ugovor_id')->comment('Relacija sa Šifarnik vrste radnih ugovora- STATUS')->nullable();
            $table->date('datum_zasnivanja_radnog_odnosa')->nullable();
            $table->date('datum_prestanka_radnog_odnosa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
