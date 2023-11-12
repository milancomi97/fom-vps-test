<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Šifarnik je povezan sa Osnovnim podacima o radnicima
     */
    public function up(): void
    {
        Schema::create('organizacionecelines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sifra_troskovnog_mesta')->nullable();
            $table->string('naziv_troskovnog_mesta', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizacionecelines');
    }
};
