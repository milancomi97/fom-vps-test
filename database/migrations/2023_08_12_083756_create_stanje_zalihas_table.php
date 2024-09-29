<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('stanje_zalihas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('magacin_id')->nullable(); // SM
            $table->unsignedBigInteger('sifra_materijala')->nullable(); // Sifra materijala
            $table->string('konto', 6)->nullable(); // Konto
            $table->decimal('cena', 18, 2)->nullable(); // Cena
            $table->decimal('kolicina', 12, 3)->nullable(); // Trenutna kolicina
            $table->decimal('vrednost', 12, 2)->nullable(); // Trenutna vrednost
            $table->decimal('pocst_kolicina', 12, 3)->nullable(); // Početna količina
            $table->decimal('pocst_vrednost', 12, 2)->nullable(); // Početna vrednost
            $table->decimal('ulaz_kolicina', 12, 3)->nullable(); // Količina ulaza
            $table->decimal('ulaz_vrednost', 12, 2)->nullable(); // Vrednost ulaza
            $table->decimal('izlaz_kolicina', 12, 3)->nullable(); // Količina izlaza
            $table->decimal('izlaz_vrednost', 12, 2)->nullable(); // Vrednost izlaza
            $table->decimal('stanje_kolicina', 12, 3)->nullable(); // Trenutna količina
            $table->decimal('stanje_vrednost', 12, 2)->nullable(); // Trenutna vrednost
            $table->decimal('st_mag', 12, 2)->nullable(); // Specifična vrednost u magacinu
            $table->timestamps();

            // Strani ključ za magacin
            $table->foreign('magacin_id')->references('id')->on('magacins')->onDelete('cascade');
            // Strani ključ za šifru materijala
            $table->foreign('sifra_materijala')->references('sifra_materijala')->on('materijals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stanje_zalihas');
    }
};
