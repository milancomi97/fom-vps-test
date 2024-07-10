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
            $table->date('M_G_date'); // MDR
            $table->float('NT1_prosecna_mesecna_zarada_u_republici', 10, 4)->nullable();
            $table->float('STOPA2_minimalna_neto_zarada_po_satu', 10, 4)->nullable();
            $table->float('STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos', 10, 4)->nullable();
            $table->float('P1_stopa_poreza', 10, 4)->nullable();
            $table->float('STOPA1_koeficijent_za_obracun_neto_na_bruto',10,8)->nullable();
            $table->float('NT2_minimalna_bruto_zarada', 10, 4)->nullable();
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
