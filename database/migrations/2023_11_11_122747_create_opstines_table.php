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
        Schema::create('opstines', function (Blueprint $table) {
            $table->id();
            $table->string('sifra_opstine')->nullable();
            $table->string('naziv_opstine', 30)->nullable();
            $table->string('sifra_drzave' )->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opstines');
    }
};