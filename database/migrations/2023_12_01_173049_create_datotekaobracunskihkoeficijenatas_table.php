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
        Schema::create('datotekaobracunskihkoeficijenatas', function (Blueprint $table) {
            $table->id();
            $table->date('datum')->nullable()->unique();
            $table->integer('mesec')->nullable();
            $table->integer('godina')->nullable();
            $table->string('status')->nullable();
            $table->integer('kalendarski_broj_dana')->nullable();
            $table->float('prosecni_godisnji_fond_sati')->nullable();
            $table->integer('vrednost_akontacije')->nullable();
            $table->integer('mesecni_fond_sati')->nullable();
            $table->integer('mesecni_fond_sati_praznika')->nullable();
            $table->string('cena_rada_tekuci')->nullable();
            $table->string('cena_rada_prethodni')->nullable();
            $table->integer('tip_todo')->nullable();
            $table->date('period_isplate_od')->nullable();
            $table->date('period_isplate_do')->nullable();

            // odaj kontrolno bolje OBPL, da li je mesec true/false zatvoren otvoren KOE
            // To polje sluzi da se validira, da li je mesec arhiviran.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datotekaobracunskihkoeficijenatas');
    }
};
