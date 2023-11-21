<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Podaci o firmi koja koristi softver
     */
    public function up(): void
    {
        Schema::create('podaciofirmis', function (Blueprint $table) {
            $table->id();
            $table->string('naziv_firme', 50)->nullable();
            $table->string('poslovno_ime', 50)->nullable();
            $table->string('skraceni_naziv_firme', 50)->nullable();
            $table->boolean('status')->nullable();
            $table->string('pravna_forma', 30)->nullable();
            $table->integer('maticni_broj')->nullable();
            $table->date('datum_osnivanja')->nullable();
            $table->string('adresa_sedista', 50)->nullable();
            $table->unsignedBigInteger('opstina_id')->nullable();
            $table->string('ulica_broj_slovo', 50)->nullable();
            $table->integer('broj_poste')->nullable();
            $table->integer('pib')->nullable();
            $table->integer('sifra_delatnosti')->nullable();
            $table->string('naziv_delatnosti', 80)->nullable();
            $table->string('racuni_u_bankama', 30)->nullable();
            $table->string('adresa_za_prijem_poste', 50)->nullable();
            $table->string('adresa_za_prijem_elektronske_poste', 30)->nullable();
            $table->string('telefon', 30)->nullable();
            $table->string('internet_adresa', 50)->nullable();
            $table->string('zakonski_zastupnik_ime_prezime', 50)->nullable();
            $table->string('zakonski_zastupnik_funkcija', 50)->nullable();
            $table->string('zakonski_zastupnik_jmbg', 50)->nullable();
            $table->boolean('obaveznik_revizije')->nullable();
            $table->string('velicina_po_razvrstavanju', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podaciofirmis');
    }
};
