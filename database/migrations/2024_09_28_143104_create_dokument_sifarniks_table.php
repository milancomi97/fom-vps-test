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
        Schema::create('dokument_sifarniks', function (Blueprint $table) {
            $table->id();
            $table->string('sd', 2); // Šifra dokumenta
            $table->string('dokument', 22); // Naziv dokumenta
            $table->boolean('vred')->default(true); // Vrednost (TRUE/FALSE)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokument_sifarniks');
    }
};
