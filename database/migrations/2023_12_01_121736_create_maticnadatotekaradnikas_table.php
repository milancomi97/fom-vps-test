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
        Schema::create('maticnadatotekaradnikas', function (Blueprint $table) {
            $table->id();
            $table->string('maticni_broj');
            $table->string('prezime');
            $table->string('ime');
            $table->unsignedBigInteger('radno_mesto');
            $table->unsignedBigInteger('isplatno_mesto');
            $table->string('tekuci_racun')->nullable();
            $table->string('redosled_poentazi');
            $table->unsignedBigInteger('vrsta_rada');
            $table->string('radna_jedinica')->nullable();
            $table->string('brigada')->nullable();
            $table->string('godine');
            $table->string('meseci');
            $table->boolean('minuli_rad_aktivan');
            $table->unsignedBigInteger('stvarna_strucna_sprema');
            $table->unsignedBigInteger('priznata_strucna_sprema');
            $table->string('osnovna_zarada');
            $table->string('jmbg');
            $table->boolean('pol_muski');
            $table->string('prosecni_sati');
            $table->string('prosecna_zarada');
            $table->string('adresa_ulica_broj');
            $table->unsignedBigInteger('opstina_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maticnadatotekaradnikas');
    }
};
