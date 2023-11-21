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
        Schema::create('radnamestas', function (Blueprint $table) {
            $table->id();
            $table->integer('rbrm_sifra_radnog_mesta')->nullable();
            $table->string('narm_naziv_radnog_mesta')->nullable();
            $table->boolean('status_active')->default(true)->nullable();
            $table->date('dident_datum_otvaranja_sifre')->nullable();
            $table->date('dclose_datum_zatvaranja_sifre')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radnamestas');
    }
};
