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
        Schema::create('vrstaradasifarniks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sifra_statusa')->nullable();
            $table->string('naziv_statusa', 50)->nullable();
            $table->integer('svp_sifra_vrste_placanja')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vrstaradasifarniks');
    }
};
