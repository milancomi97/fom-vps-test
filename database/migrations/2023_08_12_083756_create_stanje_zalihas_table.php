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
            $table->string('naziv_materijala');
            $table->unsignedBigInteger('sifra_materijala')->nullable();
            $table->unsignedBigInteger('magacin_id')->nullable();
            $table->string('standard')->nullable();
            $table->string('dimenzija')->nullable();
            $table->string('kvalitet')->nullable();
            $table->string('jedinica_mere')->nullable();
            $table->string('konto')->nullable();
            $table->integer('pocst_kolicina')->nullable();
            $table->integer('pocst_vrednost')->nullable();
            $table->integer('ulaz_kolicina')->nullable();
            $table->integer('ulaz_vrednost')->nullable();
            $table->integer('izlaz_kolicina')->nullable();
            $table->integer('izlaz_vrednost')->nullable();
            $table->integer('stanje_kolicina')->nullable();
            $table->integer('stanje_vrednost')->nullable();
            $table->integer('cena')->nullable();
//            $table->foreign('sifra_materijala')->references('sifra_materijala')->on('materijals')->onDelete('cascade');

            $table->timestamps();
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
