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
        Schema::create('jedinica_meres', function (Blueprint $table) {
            $table->id();
            $table->string('oznaka', 3); // Mapira se na JM
            $table->string('naziv', 20); // Mapira se na NAZIV_JM
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jedinica_meres');
    }
};
