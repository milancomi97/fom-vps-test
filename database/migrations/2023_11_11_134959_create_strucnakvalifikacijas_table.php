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
            $table->integer('sifra_kvalifikacije')->nullable();
            $table->string('naziv_kvalifikacije', 255)->nullable();
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
