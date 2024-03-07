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

            // TODO definiši kolone i formu
            $table->string('maticni_broj')->nullable();
            $table->unsignedBigInteger('SIFK_sifra_kreditora')->nullable();

            $table->string('IMEK_naziv_kreditora')->nullable();

            $table->string('PART_partija_poziv_na_broj')->nullable();

            $table->integer('GLAVN_glavnica')->nullable();
            $table->integer('SALD_saldo')->nullable();
            $table->integer('RATA_rata')->nullable();

            $table->boolean('POCE_pocetak_zaduzenja')->nullable();

            $table->string('DATUM_zaduzenja')->nullable();

            $table->unsignedBigInteger('obracunski_koef_id');
            $table->unsignedBigInteger('user_dpsm_id')->nullable(); // Mesec-Radnik-id
            $table->unsignedBigInteger('user_mdr_id')->nullable();

            $table->foreign('user_dpsm_id')->references('id')->on('mesecnatabelapoentazas')->onDelete('cascade');
            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas')->onDelete('cascade');
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
