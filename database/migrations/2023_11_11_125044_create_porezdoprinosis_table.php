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
        Schema::create('porezdoprinosis', function (Blueprint $table) {
            $table->id();
            $table->string('M_G_mesec_godina')->nullable();
            $table->float('IZN1_iznos_poreskog_oslobodjenja', 10, 4)->nullable();
            $table->string('OPPOR_opis_poreza', 35)->nullable();
            $table->float('P1_porez_na_licna_primanja', 10, 4)->nullable();

            // Radnik

            $table->string('OPIS1_opis_zdravstvenog_osiguranja_na_teret_radnika', 35)->nullable();
            $table->float('ZDRO_zdravstveno_osiguranje_na_teret_radnika', 10, 4)->nullable();


            $table->string('OPIS2_opis_pio_na_teret_radnika', 35)->nullable();
            $table->float('PIO_pio_na_teret_radnika', 10, 4)->nullable();

            $table->string('OPIS3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika', 35)->nullable();
            $table->float('ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika', 10, 4)->nullable();

            $table->float('UKDOPR_ukupni_doprinosi_na_teret_radnika', 10, 4)->nullable();

            // poslodavac
            $table->string('OPIS4_opis_zdravstvenog_osiguranja_na_teret_poslodavca', 35)->nullable();
            $table->float('DOPRA_zdravstveno_osiguranje_na_teret_poslodavca', 10, 4)->nullable();

            $table->string('OPIS5_opis_pio_na_teret_poslodavca', 35)->nullable();
            $table->float('DOPRB_pio_na_teret_poslodavca', 11, 4)->nullable();

            $table->float('UKDOPP_ukupni_doprinosi_na_teret_poslodavca', 10, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porezdoprinosis');
    }
};
