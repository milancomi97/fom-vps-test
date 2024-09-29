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
        Schema::create('kartices', function (Blueprint $table) {
            $table->id();
            $table->string('sd', 2); // Šifra dokumenta
            $table->string('idbr', 7); // Identifikacioni broj
            $table->string('poz', 2)->nullable(); // Pozicija
            $table->unsignedBigInteger('magacin_id')->nullable(); // Šifra magacina
            $table->unsignedBigInteger('materijal_id')->nullable(); // Šifra materijala
            $table->date('datum_k')->nullable(); // Datum knjiženja
            $table->date('datum_d')->nullable(); // Datum dokumenta
            $table->decimal('kolicina', 12, 3)->nullable(); // Količina
            $table->decimal('vrednost', 12, 2)->nullable(); // Vrednost
            $table->decimal('cena', 12, 2)->nullable(); // Cena
            $table->string('konto', 6)->nullable(); // Konto
            $table->string('tc', 6)->nullable(); // Troškovno mesto
            $table->string('poru', 7)->nullable(); // Porudžbina
            $table->decimal('norma', 12, 3)->nullable(); // Norma
            $table->string('veza', 11)->nullable(); // Veza sa dokumentom
            $table->string('mesec', 2)->nullable(); // Mesec
            $table->string('nal1', 2)->nullable(); // Nalog 1
            $table->string('nal2', 3)->nullable(); // Podbroj naloga 1
            $table->string('gru', 5)->nullable(); // Grupa
            $table->foreign('magacin_id')->references('id')->on('magacins')->onDelete('cascade');
            $table->foreign('materijal_id')->references('sifra_materijala')->on('materijals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartices');
    }
};
