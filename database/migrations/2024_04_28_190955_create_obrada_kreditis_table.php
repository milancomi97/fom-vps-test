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
        Schema::create('obrada_kreditis', function (Blueprint $table) {
            $table->id();
            $table->string('maticni_broj');
            $table->string('sifra_vrste_placanja')->nullable(); // DVPL_vrste_palcanja
            $table->string('naziv_vrste_placanja')->nullable(); // DVPL_vrste_palcanja
            $table->string('SIFK_sifra_kreditora')->nullable(); //MKRE  kreditori samo KREDITI
            $table->string('PART_partija_kredita')->nullable(); // DKRE Kreditori
            $table->string('KESC_prihod_rashod_tip')->nullable(); // DVPL_vrste_palcanja
            $table->float('GLAVN_glavnica',15,4)->nullable();
            $table->float('SALD_saldo',15,4)->nullable();
            $table->float('RATA_rata',15,4)->nullable();
            $table->boolean('POCE_pocetak_zaduzenja')->nullable();
            $table->float('RATP_prethodna',15,4)->nullable();
            $table->float('STSALD_Prethodni_saldo',15,4)->nullable(); // obracunava se
            $table->date('DATUM_zaduzenja')->nullable();


//'GLAV'
//'RATA'
//'POCE'
//'RATP'
//'RBZA'
//'STSALD'
//'HKMB'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obrada_kreditis');
    }
};
