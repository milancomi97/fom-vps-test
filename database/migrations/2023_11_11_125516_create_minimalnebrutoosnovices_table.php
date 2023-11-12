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
        Schema::create('minimalnebrutoosnovices', function (Blueprint $table) {
            $table->id();
            $table->integer('mesec')->nullable();
            $table->integer('godina')->nullable();
            $table->decimal('nt1_prosecna_mesecna_osnovica', 10, 2)->nullable();
            $table->decimal('stopa2_minimalna_neto_zarada_po_satu', 10, 2)->nullable();
            $table->decimal('stopa6_koeficijent_najvise_osnovice_za_obracun_doprinos', 10, 2)->nullable();
            $table->decimal('p1_stopa_poreza', 5, 2)->nullable();
            $table->decimal('stopa1_koeficijent_za_obracun_neto_na_bruto', 10, 2)->nullable();
            $table->decimal('nt3_najniza_osnovica_za_placanje_doprinos', 10, 2)->nullable();
            $table->decimal('nt2_minimalna_bruto_zarada', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minimalnebrutoosnovices');
    }
};
