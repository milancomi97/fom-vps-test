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
//        Schema::create('porudzbina_materijals', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('porudzbina_id');
//            $table->unsignedBigInteger('materijal_id');
//            $table->foreign('porudzbina_id')->references('id')->on('porudzbines')->onDelete('cascade');
//            $table->foreign('materijal_id')->references('sifra_materijala')->on('materijals')->onDelete('cascade');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porudzbina_materijals');
    }
};
