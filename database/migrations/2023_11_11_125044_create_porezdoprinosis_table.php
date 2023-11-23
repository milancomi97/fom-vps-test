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
            $table->integer('mesec')->nullable();
            $table->integer('godina')->nullable();

            $table->string('opis0_opis_iznos_poreskog_oslobadjanja', 35)->nullable();
            $table->decimal('izn1_iznos_poreskog_oslobadjanja', 10, 2)->nullable();

            $table->string('oppor_opis_poreza', 35)->nullable();
            $table->decimal('p1_porez', 10, 2)->nullable();

            // Radnik

            $table->string('opis1_opis_zdravstvenog_osiguranja_na_teret_radnika', 35)->nullable();
            $table->decimal('zdro_zdravstveno_osiguranje_na_teret_radnika', 10, 2)->nullable();


            $table->string('opis2_opis_pio_na_teret_radnika', 35)->nullable();
            $table->decimal('pio_pio_na_teret_radnika', 10, 2)->nullable();

            $table->string('opis3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika', 35)->nullable();
            $table->decimal('onez_osiguranje_od_nezaposlenosti_na_teret_radnika', 10, 2)->nullable();

            $table->decimal('ukdop_ukupni_doprinosi_na_teret_radnika', 10, 2)->nullable();

            // poslodavac
            $table->string('opis4_opis_zdravstvenog_osiguranja_na_teret_poslodavca', 35)->nullable();
            $table->decimal('dopzp_zdravstveno_osiguranje_na_teret_poslodavca', 10, 2)->nullable();

            $table->string('opis5_opis_pio_na_teret_poslodavca', 35)->nullable();
            $table->decimal('dopp_pio_na_teret_poslodavca', 11, 6)->nullable();

            $table->decimal('ukdopp_ukupni_doprinosi_na_teret_poslodavca', 10, 2)->nullable();
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
