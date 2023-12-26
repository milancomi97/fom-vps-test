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
        Schema::create('mesecnatabelapoentazas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organizaciona_celina_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('obracunski_koef_id');
            $table->json('vrste_placanja');
            $table->date('datum');
            $table->string('maticni_broj');
            $table->string('prezime');
            $table->string('srednje_ime')->nullable();
            $table->string('ime');
            $table->string('napomena')->nullable();
            $table->integer('status_poentaze')->nullable();
            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas')->onDelete('cascade');
            $table->foreign('organizaciona_celina_id')->references('id')->on('organizacionecelines');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesecnatabelapoentazas');
    }
};
