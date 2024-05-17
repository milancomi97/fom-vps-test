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
        Schema::create('obrada_dkop_sve_vrste_placanjas', function (Blueprint $table) {

            $table->string('maticni_broj'); // MDR
            $table->string('sifra_vrste_placanja')->nullable(); // DVPL_vrste_palcanja
            $table->string('naziv_vrste_placanja')->nullable(); // DVPL_vrste_palcanja
            $table->string('SLOV_grupa_vrste_placanja')->nullable(); // DVPL_vrste_palcanja
            $table->integer('sati')->nullable(); // SVUDA
            $table->float('iznos',15,4)->nullable(); // SVUDA
            $table->float('procenat',15,4)->nullable();
            $table->float('SALD_saldo',15,5)->nullable(); // SVUDA
            $table->string('POK2_obracun_minulog_rada')->nullable(); // DVPL_vrste_palcanja
            $table->string('KOEF_osnovna_zarada')->nullable(); // MDR
            $table->string('RBRM_radno_mesto')->nullable(); // MDR
            $table->string('KESC_prihod_rashod_tip')->nullable(); // DVPL_vrste_palcanja

            $table->string('P_R_oblik_rada')->nullable(); // MDR


            $table->string('RBIM_isplatno_mesto_id')->nullable(); // MDR
            $table->unsignedBigInteger('troskovno_mesto_id')->nullable(); // KADR sifra isplatnog mesta // Valjda ima MDR

            $table->unsignedBigInteger('organizaciona_celina_id')->nullable(); // KADR sifra isplatnog mesta // Valjda ima MDR

            $table->string('SIFK_sifra_kreditora')->nullable(); //MKRE  kreditori samo KREDITI

            $table->float('STSALD_Prethodni_saldo',15,5)->nullable(); // obracunava se

            $table->string('NEAK_neopravdana_akontacija')->nullable(); // obracunava se


            $table->string('PART_partija_kredita')->nullable(); // DKRE Kreditori
            $table->float('POROSL_poresko_oslobodjenje',15,5)->nullable(); // DPOR


            $table->unsignedBigInteger('obracunski_koef_id')->nullable();
            $table->unsignedBigInteger('user_dpsm_id')->nullable(); // Mesec-Radnik-id
            $table->unsignedBigInteger('user_mdr_id')->nullable();

            $table->foreign('user_dpsm_id')->references('id')->on('mesecnatabelapoentazas')->onDelete('cascade');
            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas')->onDelete('cascade');
            $table->foreign('user_mdr_id')->references('id')->on('maticnadatotekaradnikas')->onDelete('cascade');
            $table->string('tip_unosa')->nullable();

            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obrada_dkop_sve_vrste_placanjas');
    }
};
