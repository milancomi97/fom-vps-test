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
        Schema::create('vrsteplacanjas', function (Blueprint $table) {
            $table->id();
            $table->integer('rbvp_sifra_vrste_placanja')->nullable();
            $table->string('naziv_naziv_vrste_placanja', 255)->nullable();
            $table->string('formula_formula_za_obracun', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vrsteplacanjas');
    }
};
