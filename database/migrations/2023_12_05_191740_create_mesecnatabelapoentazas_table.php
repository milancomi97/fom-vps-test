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
            $table->string('ime');
            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas')->onDelete('cascade');
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
