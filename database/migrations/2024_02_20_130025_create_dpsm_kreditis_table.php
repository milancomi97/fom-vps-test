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
        Schema::create('dpsm_kreditis', function (Blueprint $table) {
            $table->id();

            $table->string('maticni_broj');
            $table->string('SIFK_sifra_kreditora')->nullable();

            $table->string('IMEK_naziv_kreditora')->nullable();

            $table->string('PART_partija_poziv_na_broj')->nullable();

            $table->float('GLAVN_glavnica',15,4)->nullable();
            $table->float('SALD_saldo',15,4)->nullable();
            $table->float('RATA_rata',15,4)->nullable();
            $table->float('RATP_prethodna',15,4)->nullable();

            $table->float('RBZA',15,4)->nullable();
            $table->float('RATP',15,4)->nullable();
            $table->float('RATB',15,4)->nullable();

            $table->boolean('POCE_pocetak_zaduzenja')->nullable();

            $table->date('DATUM_zaduzenja')->nullable();

            $table->unsignedBigInteger('obracunski_koef_id')->nullable();
            $table->unsignedBigInteger('user_dpsm_id')->nullable(); // Mesec-Radnik-id
            $table->unsignedBigInteger('user_mdr_id');

//            $table->foreign('user_dpsm_id')->references('id')->on('mesecnatabelapoentazas')->onDelete('cascade');
//            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas')->onDelete('cascade');
            $table->foreign('user_mdr_id')->references('id')->on('maticnadatotekaradnikas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpsm_kreditis');
    }
};
