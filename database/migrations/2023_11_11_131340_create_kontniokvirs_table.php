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
        Schema::create('kontniokvirs', function (Blueprint $table) {
            $table->id();
            $table->string('sifra_konta', 6)->nullable();
            $table->string('naziv_konta', 50)->nullable();
            $table->string('vrsta_analitickog_konta', 1)->nullable();
            $table->string('pdv', 2)->nullable();
            $table->string('pogonsko', 2)->nullable();
            $table->string('direktna_raspodela', 2)->nullable();
            $table->string('indirektna_raspodela', 2)->nullable();
            $table->decimal('procenat_preracuna_za_troskove_reklame', 6, 2)->nullable();
            $table->string('klasa_9', 2)->nullable();
            $table->string('bilans_stanja_aop', 4)->nullable();
            $table->string('bilans_stanja_formula', 50)->nullable();
            $table->string('bilans_uspeha_aop', 4)->nullable();
            $table->string('bilans_uspeha_formula', 50)->nullable();
            $table->string('statisticki_izvestaj_aop', 4)->nullable();
            $table->string('statisticki_izvestaj_formula', 50)->nullable();
            $table->string('izvestaj_o_ostalom_rezultatu_aop', 4)->nullable();
            $table->string('izvestaj_o_ostalom_rezultatu_formula', 50)->nullable();
            $table->string('izvestaj_o_tokovima_gotovine_aop', 4)->nullable();
            $table->string('izvestaj_o_tokovima_gotovine_formula', 50)->nullable();
            $table->string('posebni_podaci_aop', 4)->nullable();
            $table->string('posebni_podaci_formula', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontniokvirs');
    }
};
