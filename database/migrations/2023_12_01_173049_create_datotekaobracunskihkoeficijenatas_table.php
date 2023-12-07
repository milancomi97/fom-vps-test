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
            $table->string('status')->nullable();
            $table->integer('kalendarski_broj_dana')->nullable();
            $table->float('prosecni_godisnji_fond_sati')->nullable();
            $table->integer('mesecni_fond_sati')->nullable();
            $table->string('cena_rada_tekuci')->nullable();
            $table->string('cena_rada_prethodni')->nullable();
            $table->integer('tip_todo')->nullable();
            $table->date('period_isplate_od')->nullable();
            $table->date('period_isplate_do')->nullable();
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
