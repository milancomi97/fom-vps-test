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
        Schema::create('maticnadatotekaradnikas', function (Blueprint $table) {
            $table->id();
            $table->string('MBRD_maticni_broj')->nullable();
            $table->string('PREZIME_prezime')->nullable();
            $table->string('IME_ime')->nullable();
            $table->unsignedBigInteger('RBRM_radno_mesto')->nullable(); // sifra radnog mesta
            $table->unsignedBigInteger('RBIM_isplatno_mesto_id')->nullable(); // sifra isplatnog mesta // NOVO DODATO
            $table->string('ZRAC_tekuci_racun')->nullable();
            $table->string('BRCL_redosled_poentazi')->nullable();
            $table->string('BR_vrsta_rada')->nullable();
            $table->string('P_R_oblik_rada')->nullable(); // DODATI NA FORMI
            $table->string('RJ_radna_jedinica')->nullable();
            $table->string('BRIG_brigada')->nullable();
            $table->string('GGST_godine_staza')->nullable();
            $table->string('MMST_meseci_staza')->nullable();
            $table->boolean('MRAD_minuli_rad_aktivan')->nullable(); // D tačno
            $table->boolean('PREB_prebacaj')->nullable(); // 1 // DODATI NA FORMI
            $table->unsignedBigInteger('RBSS_stvarna_strucna_sprema')->nullable();
            $table->unsignedBigInteger('RBPS_priznata_strucna_sprema')->nullable();
            $table->string('KOEF_osnovna_zarada')->nullable();
            $table->string('KOEF1_prethodna_osnovna_zarada')->nullable(); // Novo dodato
            $table->string('LBG_jmbg')->nullable();
            $table->string('POL_pol')->nullable();
            $table->string('PRCAS_ukupni_sati_za_ukupan_bruto_iznost')->nullable();
            $table->string('PRIZ_ukupan_bruto_iznos')->nullable();
            $table->string('BROJ_broj_meseci_za_obracun')->nullable(); // broj meseci znacajan za obracun proseka
            $table->string('DANI_kalendarski_dani')->nullable(); // broj meseci znacajan za obracun proseka
            $table->string('IZNETO1_bruto_zarada_za_akontaciju')->nullable(); // IZNETO1
            $table->string('POROSL1_poresko_oslobodjenje_za_akontaciju')->nullable(); // POROSL1,N,12,2
            $table->string('SIP1_porez_za_akontaciju')->nullable(); // SIP1,N,12,2
            $table->string('BROSN1_minimalna_osnovica_za_obracun_doprinosa_za_akontaciju')->nullable(); // BROSN1,N,12,2
            $table->string('ZDRR1_zdravstveno_osiguranje_na_teret_radnika_za_akontaciju')->nullable(); // PIOR1,N,12,2
            $table->string('ZDRP1_zdravstveno_osiguranje_na_teret_poslodavca_za_akontaciju')->nullable(); // PIOP1,N,12,2
            $table->string('ONEZR1_osig_nezaposlenosti_na_teret_radnika_za_akontaciju')->nullable(); // ZDRR1,N,12,2
            $table->string('PIOR_ukupni_pio_doprinos_na_teret_radnika')->nullable(); // ZDRP1,N,12,2
            $table->string('PIOP_ukupni_pio_doprinos_na_teret_poslodavca')->nullable(); // ONEZR1,N,12,2
            $table->string('ONEZR_ukupni_doprinos_za_nezaposlenost_na_teret_radnika')->nullable(); // PIOR,N,12,2
            $table->string('ZDRR_ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_radnika')->nullable(); // PIOP,N,12,2
            $table->string('ZDRP_ukupni_doprinos_zdrav_osig_teret_poslodavca')->nullable(); // ZDRR,N,12,2
            $table->string('BROSN_bruto_zarada_za_obracun_doprinosa')->nullable(); // ZDRR,N,12,2
            $table->string('POROSL_ukupno_poresko_oslobodjenje')->nullable(); // ZDRP,N,12,2
            $table->string('SIP_ukupni_porezi')->nullable(); // BROSN,N,12,2
            $table->boolean('ACTIVE_aktivan')->nullable(); // IZNETO,N,12,2
            $table->string('IZNETO_ukupna_bruto_zarada')->nullable(); // IZNETO,N,12,2
            $table->string('KFAK_korektivni_faktor')->nullable(); // IZNETO,N,12,2
            $table->unsignedBigInteger('opstina_id')->nullable(); // sifra opstine 4 broja
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedBigInteger('troskovno_mesto_id'); // novo
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maticnadatotekaradnikas');
    }
};
