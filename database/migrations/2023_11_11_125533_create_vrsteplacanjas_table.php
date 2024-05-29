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
        Schema::create('vrsteplacanjas', function (Blueprint $table) {
            $table->id();
            $table->string('rbvp_sifra_vrste_placanja')->nullable(); //RBVP_sifra_vrste_placanja
            $table->string('naziv_naziv_vrste_placanja', 255)->nullable(); // NAZI_naziv_vrste_placanja
            $table->string('formula_formula_za_obracun', 255)->nullable(); //BLOK_formula_za_obracun
            $table->integer('redosled_poentaza_zaglavlje')->nullable(); // POEN_redosled_poentaza_zaglavlje
            $table->integer('redosled_poentaza_opis')->nullable(); //RIK_redosled_poentaza_opis
            $table->string('SLOV_grupe_vrsta_placanja', 255)->nullable(); //BLOK_formula_za_obracun
            $table->integer('POK1_grupisanje_sati_novca')->nullable(); //BLOK_formula_za_obracun
            $table->string('POK2_obracun_minulog_rada', 255)->nullable(); //BLOK_formula_za_obracun
            $table->string('POK3_prikaz_kroz_unos', 255)->nullable(); //BLOK_formula_za_obracun
            $table->string('KESC_prihod_rashod_tip', 255)->nullable(); //BLOK_formula_za_obracun
            $table->boolean('EFSA_efektivni_sati')->nullable(); //BLOK_formula_za_obracun
            $table->integer('PRKV_prosek_po_kvalifikacijama')->nullable(); //BLOK_formula_za_obracun
            $table->string('OGRAN_ogranicenje_za_minimalac', 255)->nullable(); //BLOK_formula_za_obracun
            $table->integer('PROSEK_prosecni_obracun')->nullable(); //BLOK_formula_za_obracun
            $table->string('VARI_minuli_rad', 255)->nullable(); //BLOK_formula_za_obracun
            $table->boolean('DOVP_tip_vrste_placanja')->nullable(); //BLOK_formula_za_obracun
            $table->integer('PLAC')->nullable(); // DVPL_vrste_palcanja
            $table->integer('KATEG_sumiranje_redova_poentaza' )->nullable(); //BLOK_formula_za_obracun
            $table->integer('ANOM_poentaza_provera' )->nullable(); //BLOK_formula_za_obracun














            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vrsteplacanjas');
    }
};
