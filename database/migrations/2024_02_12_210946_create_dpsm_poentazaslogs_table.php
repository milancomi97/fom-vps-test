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
        Schema::create('dpsm_poentazaslogs', function (Blueprint $table) {
            // Unos poentera, varijabilni troškovi, po slogu
            $table->id();
            $table->string('maticni_broj');
            $table->string('sifra_vrste_placanja')->nullable();
            $table->string('naziv_vrste_placanja')->nullable();
            $table->string('SLOV_grupa_vrste_placanja')->nullable(); // vrste placanja SLOV_grupe_vrsta_placanja
            $table->integer('sati')->nullable();
            $table->float('iznos',15,4)->nullable();
            $table->float('procenat',15,4)->nullable();

            $table->string('BRIG_brigada')->nullable();
            $table->string('RJ_radna_jedinica')->nullable();
            $table->string('POK2_obracun_minulog_rada')->nullable();


            $table->unsignedBigInteger('obracunski_koef_id')->nullable();
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
        Schema::dropIfExists('dpsm_poentazaslogs');
    }
};
