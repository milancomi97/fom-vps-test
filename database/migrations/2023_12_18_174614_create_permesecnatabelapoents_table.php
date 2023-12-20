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
        Schema::create('permesecnatabelapoents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organizaciona_celina_id');
            $table->unsignedBigInteger('obracunski_koef_id');

            $table->integer('status');
            $table->json('poenteri_ids');
            $table->json('poenteri_status')->nullable();
            $table->json('odgovorna_lica_ids');
            $table->json('odgovorna_lica_status')->nullable();
            $table->date('datum')->nullable();

            $table->foreign('organizaciona_celina_id')->references('id')->on('organizacionecelines');
            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permesecnatabelapoents');
    }
};
