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
        Schema::create('dpsm_akontacijes', function (Blueprint $table) {

            $table->id();
            $table->string('maticni_broj')->nullable();
            $table->string('sifra_vrste_placanja')->nullable();
            $table->string('SLOV_grupa_vrste_placanja')->nullable();
            $table->integer('sati')->nullable();
            $table->integer('iznos')->nullable();
            $table->integer('procenat')->nullable();
            $table->string('POK2_obracun_minulog_rada')->nullable();

            $table->unsignedBigInteger('obracunski_koef_id');
            $table->unsignedBigInteger('user_dpsm_id')->nullable(); // Mesec-Radnik-id

            $table->foreign('user_dpsm_id')->references('id')->on('mesecnatabelapoentazas')->onDelete('cascade');
            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpsm_akontacijes');
    }
};
