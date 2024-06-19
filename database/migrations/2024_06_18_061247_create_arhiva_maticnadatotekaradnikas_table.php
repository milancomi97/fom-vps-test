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
        Schema::create('arhiva_maticnadatotekaradnikas', function (Blueprint $table) {
            $table->id();
            $table->string('M_G_mesec_godina')->nullable();
            $table->date('M_G_date')->nullable();
            $table->string('MBRD_maticni_broj')->nullable();
            $table->string('PREZIME_prezime')->nullable();
            $table->string('srednje_ime')->nullable();
            $table->string('IME_ime')->nullable();
            $table->unsignedBigInteger('RBRM_radno_mesto')->nullable(); // sifra radnog mesta
            $table->unsignedBigInteger('RBIM_isplatno_mesto_id')->nullable(); // sifra isplatnog mesta // NOVO DODATO
            $table->string('ZRAC_tekuci_racun')->nullable();
            $table->integer('BRCL_redosled_poentazi')->nullable();
            $table->string('BR_vrsta_rada')->nullable();
            $table->string('P_R_oblik_rada')->nullable(); // DODATI NA FORMI
            $table->string('RJ_radna_jedinica')->nullable();
            $table->string('BRIG_brigada')->nullable();
            $table->string('GGST_godine_staza')->nullable();
            $table->string('MMST_meseci_staza')->nullable();
            $table->boolean('MRAD_minuli_rad_aktivan')->nullable(); // D tačno
            $table->float('PREB_prebacaj')->nullable(); // 1 // DODATI NA FORMI
            $table->integer('DANI_kalendarski_dani')->nullable(); // broj meseci znacajan za obracun proseka
            $table->string('RBSS_stvarna_strucna_sprema')->nullable();
            $table->string('RBPS_priznata_strucna_sprema')->nullable();
            $table->float('KOEF_osnovna_zarada',15,4)->nullable();
            $table->float('KOEF1_prethodna_osnovna_zarada',15,4)->nullable(); // Novo dodato
            $table->string('LBG_jmbg')->nullable();
            $table->string('POL_pol')->nullable();
            $table->float('PRCAS_ukupni_sati_za_ukupan_bruto_iznost',15,4)->nullable();
            $table->float('PRIZ_ukupan_bruto_iznos',15, 4)->nullable();
            $table->string('BROJ_broj_meseci_za_obracun')->nullable(); // broj meseci znacajan za obracun proseka
            $table->float('IZNETO1_bruto_zarada_za_akontaciju',15,4)->nullable(); // IZNETO1
            $table->float('POROSL1_poresko_oslobodjenje_za_akontaciju',15,4)->nullable(); // POROSL1,N,12,2
            $table->float('SIP1_porez_za_akontaciju',15,4)->nullable(); // SIP1,N,12,2
            $table->float('BROSN1_minimalna_osnovica_za_obracun_doprinosa_za_akontaciju',15,4)->nullable(); // BROSN1,N,12,2
            $table->float('ZDRR1_zdravstveno_osiguranje_na_teret_radnika_za_akontaciju',15,4)->nullable(); // PIOR1,N,12,2
            $table->float('ZDRP1_zdravstveno_osiguranje_na_teret_poslodavca_za_akontaciju',15,4)->nullable(); // PIOP1,N,12,2
            $table->float('ONEZR1_osig_nezaposlenosti_na_teret_radnika_za_akontaciju',15,4)->nullable(); // ZDRR1,N,12,2
            $table->float('PIOR_ukupni_pio_doprinos_na_teret_radnika',15,4)->nullable(); // ZDRP1,N,12,2
            $table->float('PIOP_ukupni_pio_doprinos_na_teret_poslodavca',15,4)->nullable(); // ONEZR1,N,12,2
            $table->float('ONEZR_ukupni_doprinos_za_nezaposlenost_na_teret_radnika',15,4)->nullable(); // PIOR,N,12,2
            $table->float('ZDRR_ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_radnika',15,4)->nullable(); // PIOP,N,12,2
            $table->float('ZDRP_ukupni_doprinos_zdrav_osig_teret_poslodavca',15,4)->nullable(); // ZDRR,N,12,2
            $table->float('BROSN_bruto_zarada_za_obracun_doprinosa',15,4)->nullable(); // ZDRR,N,12,2
            $table->float('POROSL_ukupno_poresko_oslobodjenje',15,4)->nullable(); // ZDRP,N,12,2
            $table->float('SIP_ukupni_porezi',15,4)->nullable(); // BROSN,N,12,2
            $table->float('IZNETO_ukupna_bruto_zarada',15,4)->nullable(); // IZNETO,N,12,2
            $table->boolean('ACTIVE_aktivan')->nullable(); // IZNETO,N,12,2
            $table->string('KFAK_korektivni_faktor')->nullable(); // IZNETO,N,12,2
            $table->string('opstina_id')->nullable();
            $table->string('adresa_ulica_broj')->nullable();
            $table->string('adresa_mesto')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedBigInteger('troskovno_mesto_id'); // novo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arhiva_maticnadatotekaradnikas');
    }
};
