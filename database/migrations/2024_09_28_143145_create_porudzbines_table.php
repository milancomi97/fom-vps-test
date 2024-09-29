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
        Schema::create('porudzbines', function (Blueprint $table) {
            $table->id();
            $table->string('rbpo', 8); // Redni broj porudžbine
            $table->string('napo', 50); // Naziv porudžbine
            $table->string('mbkom', 7); // Šifra poslovnog partnera
            $table->date('dident')->nullable(); // Datum otvaranja
            $table->date('dclose')->nullable(); // Datum zatvaranja
            $table->string('ugovor', 10)->nullable(); // Šifra ugovora
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porudzbines');
    }
};
