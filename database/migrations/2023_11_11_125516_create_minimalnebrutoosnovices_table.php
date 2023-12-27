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
            $table->string('M_G_mesec_dodina')->nullable();
            $table->decimal('NT1_prosecna_mesecna_zarada_u_republici', 10, 2)->nullable();
            $table->decimal('STOPA2_minimalna_neto_zarada_po_satu', 10, 2)->nullable();
            $table->decimal('STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos', 10, 2)->nullable();
            $table->decimal('P1_stopa_poreza', 5, 2)->nullable();
            $table->integer('STOPA1_koeficijent_za_obracun_neto_na_bruto')->nullable();
            $table->decimal('NT2_minimalna_bruto_zarada', 60, 2)->nullable();
//            $table->decimal('NT3_najniza_osnovica_za_placanje_doprinos', 10, 2)->nullable();
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
