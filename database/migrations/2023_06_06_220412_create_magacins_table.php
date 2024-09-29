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
        Schema::create('magacins', function (Blueprint $table) {
            $table->id();
            $table->string('sm', 2)->unique(); // Polje SM iz CSV-a, šifra magacina
            $table->string('name', 40); // Naziv magacina, mapirano na MAGACIN
            $table->string('location')->nullable(); // Opcionalna lokacija magacina
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magacins');
    }
};
