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
        Schema::create('drzaves', function (Blueprint $table) {
            $table->id();
            $table->string('sifra_drzave', 5)->nullable();
            $table->string('naziv_drzave', 30)->nullable();
            $table->string('oznaka_drzave', 5)->nullable();
            $table->string('oznaka_valute', 5)->nullable();
            $table->string('opis_valute', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drzaves');
    }
};
