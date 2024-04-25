<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Šifarnik je povezan sa Osnovnim podacima o radnicima
     */
    public function up(): void
    {
        Schema::create('organizacionecelines', function (Blueprint $table) {
            $table->id();
            $table->integer('sifra_troskovnog_mesta')->nullable();
            $table->string('naziv_troskovnog_mesta', 255)->nullable();
            $table->json('poenteri_ids')->nullable();
            $table->json('odgovorna_lica_ids')->nullable();
            $table->json('odgovorni_direktori_pravila')->nullable();
            $table->boolean('active')->nullable();
//            "[""64"", ""678""]","[""63"", ""679""]"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizacionecelines');
    }
};
