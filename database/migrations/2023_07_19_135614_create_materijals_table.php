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

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gru')->unique(); // Polje GRU iz CSV-a, verovatno šifra kategorije
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });


        Schema::create('materijals', function (Blueprint $table) {
            $table->id();
            $table->index('sifra_materijala');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sifra_materijala');// Dodavanje jedinstvenog indeksa
            $table->string('naziv_materijala')->nullable();
            $table->string('standard')->nullable();
            $table->string('dimenzija')->nullable();
            $table->string('kvalitet')->nullable();
            $table->string('jedinica_mere')->nullable();
            $table->float('tezina',8,2)->nullable();
            $table->string('dimenzije')->nullable();
            $table->string('dimenzija_1_value')->nullable();
            $table->string('dimenzija_1')->nullable();
            $table->string('dimenzija_2_value')->nullable();
            $table->string('dimenzija_2')->nullable();
            $table->string('dimenzija_3_value')->nullable();

            $table->unique(['sifra_materijala', 'dimenzija']);

            $table->string('sifra_standarda')->nullable();
            $table->string('napomena')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materijals');
        Schema::dropIfExists('categories');
    }
};
