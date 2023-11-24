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
        Schema::create('oblikradas', function (Blueprint $table) {
            $table->id();
            $table->string('sifra_oblika_rada', 35)->nullable();
            $table->string('naziv_oblika_rada')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oblikradas');
    }
};
