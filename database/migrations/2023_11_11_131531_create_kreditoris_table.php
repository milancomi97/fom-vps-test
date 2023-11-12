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
        Schema::create('kreditoris', function (Blueprint $table) {
            $table->id();
            $table->integer('sifk_sifra_kreditora', )->nullable();
            $table->string('imek_naziv_kreditora', 30)->nullable();
            $table->string('sediste_kreditora', 15)->nullable();
            $table->string('tekuci_racun_za_uplatu', 30)->nullable();
            $table->string('partija_kredita', 25)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kreditoris');
    }
};
