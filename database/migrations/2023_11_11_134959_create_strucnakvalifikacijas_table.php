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
        Schema::create('strucnakvalifikacijas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sifra_kvalifikacije')->nullable();
            $table->string('naziv_kvalifikacije', 35)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strucnakvalifikacijas');
    }
};