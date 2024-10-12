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
            $table->float('cena', 18, 2)->nullable(); // Cena
            $table->integer('kolicina')->nullable(); // Trenutna kolicina
            $table->float('vrednost', 12, 2)->nullable(); // Trenutna vrednost
            $table->float('pocst_kolicina', 12, 3)->nullable(); // Početna količina
            $table->float('pocst_vrednost', 12, 2)->nullable(); // Početna vrednost
            $table->float('ulaz_kolicina', 12, 3)->nullable(); // Količina ulaza
            $table->float('ulaz_vrednost', 12, 2)->nullable(); // Vrednost ulaza
            $table->float('izlaz_kolicina', 12, 3)->nullable(); // Količina izlaza
            $table->float('izlaz_vrednost', 12, 2)->nullable(); // Vrednost izlaza
            $table->float('stanje_kolicina', 12, 3)->nullable(); // Trenutna količina
            $table->float('stanje_vrednost', 12, 2)->nullable(); // Trenutna vrednost
            $table->float('st_mag', 12, 2)->nullable(); // Specifična vrednost u magacinu
            $table->timestamps();

            // Strani ključ za magacin
//            $table->foreign('magacin_id')->references('id')->on('magacins')->onDelete('cascade');
//            // Strani ključ za šifru materijala
//            $table->foreign('sifra_materijala')->references('sifra_materijala')->on('materijals')->onDelete('cascade');
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
