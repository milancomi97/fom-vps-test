<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Banke
     */
    public function up(): void
    {
        Schema::create('isplatnamestas', function (Blueprint $table) {
            $table->id();
            $table->integer('rbim_sifra_isplatnog_mesta')->nullable();
            $table->string('naim_naziv_isplatnog_mesta', 50)->nullable();
            $table->string('tekuci_racun_banke', 30)->nullable();
            $table->string('pb_poziv_na_broj', 2)->nullable();
            $table->string('partija_racuna', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isplatnamestas');
    }
};
