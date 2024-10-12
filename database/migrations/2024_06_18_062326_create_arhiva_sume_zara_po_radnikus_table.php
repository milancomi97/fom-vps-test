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
        Schema::create('arhiva_sume_zara_po_radnikus', function (Blueprint $table) {
            $table->id();

            $table->string('M_G_mesec_godina');
            $table->date('M_G_date');
            $table->string('maticni_broj');
            $table->integer('rbim_sifra_isplatnog_mesta')->nullable();
            $table->integer('sifra_troskovnog_mesta')->nullable();
            $table->integer('RBPS_strucna_sprema')->nullable();

            $table->integer('RBOP_sifra_opstine')->nullable();
            $table->integer('RBRM_redni_broj_radnog_mesta')->nullable();

            $table->string('ime')->nullable();
            $table->string('prezime')->nullable();
            $table->string('srednje_ime')->nullable();
            $table->string('LBG_jmbg')->nullable();

            $table->string('GGST_godine_staza')->nullable();
            $table->string('MMST_meseci_staza')->nullable();

            $table->float('SSZNE_suma_sati_zarade',15,4)->nullable();
            $table->float('SIZNE_ukupni_iznos_zarade',15,4)->nullable();

            $table->float('SSNNE_suma_sati_naknade',15,4)->nullable(); // bolovanja
            $table->float('SINNE_ukupni_iznos_naknade',15,4)->nullable(); // bolovanja

            $table->float('IZNETO_zbir_ukupni_iznos_naknade_i_naknade',15,4)->nullable(); //

            $table->float('SID_ukupni_iznos_doprinosa',15,4)->nullable(); //  ( penzijsko, zdravstve i nezaposlenost)
            $table->float('SIP_ukupni_iznos_poreza',15,4)->nullable(); //  fiksna p
            $table->float('SID_ukupni_iznos_poreza_i_doprinosa',15,4)->nullable(); //  fiksna p

            $table->float('SIOB_ukupni_iznos_obustava',15,4)->nullable(); // fiksna placanja
            $table->float('EFSATI_ukupni_iznos_efektivnih_sati',15,4)->nullable(); // DVPL->EFSA ako bude D

            $table->float('AKONT_iznos_primljene_akontacije',15,4)->nullable();
            $table->float('NEAK_neopravdana_akontacija',15,4)->nullable();
            $table->float('ZARKR_ukupni_zbir_kredita',15,4)->nullable();

            $table->float('EFIZNO_kumulativ_iznosa_za_efektivne_sate',15,4)->nullable();

            $table->float('MINIM_minimalna_zarada',15,4)->nullable();


            $table->float('TOPLI_obrok_iznos',15,4)->nullable(); // 019
            $table->float('TOPLI_obrok_sati',15,4)->nullable(); // 019


            $table->float('PRIZ_prosecni_iznos_godina',15,4)->nullable();
            $table->float('PRCAS_prosecni_sati_godina',15,4)->nullable();


            $table->float('KOREKC_dotacija_za_minimalnu_bruno_osnovicu',15,4)->nullable();

            $table->float('REGRES_iznos_regresa',15,4)->nullable();
            $table->float('POROSL_poresko_oslobodjenje',15,4)->nullable();



            $table->float('NETO_neto_zarada',15,4)->nullable(); // kada se sve sto je gore odbije (gore je bruto)
            $table->float('IZNETO1_prva_isplata_akontacija')->nullable();
            $table->float('SIP1_porez_prva_isplata')->nullable();

            $table->float('BROSN_osnovica_za_doprinose')->nullable();
            $table->float('BROSN1_osnovica_za_doprinose_prva_isplata',15,4)->nullable();

            $table->float('PIOR_penzijsko_osiguranje_na_teret_radnika',15,4)->nullable();

            $table->float('ZDRR_zdravstveno_osiguranje_na_teret_radnika',15,4)->nullable();

            $table->float('ONEZR_osiguranje_od_nezaposlenosti_teret_radnika',15,4)->nullable();
            $table->float('PIOP_penzijsko_osiguranje_na_teret_poslodavca',15,4)->nullable();


            $table->float('ZDRP_zdravstveno_osiguranje_na_teret_poslodavca',15,4)->nullable();
            $table->float('ONEZP_osiguranje_od_nezaposlenosti_teret_poslodavca',15,4)->nullable();

            $table->string('ZRAC_tekuci_racun')->nullable();

            $table->float('POROSL1_poresko_oslobodjenje_za_prvu_isplatu',15,4)->nullable();
            $table->float('PIOR1_penzijsko_osiguranje_radnik_prva_isplata',15,4)->nullable();
            $table->float('PIOP1_penzijsko_osiguranje_poslodavac_prva_isplata',15,4)->nullable();

            $table->float('ZDRR1_zdravstveno_osig_radnik_prva_isplata',15,4)->nullable();
            $table->float('ZDRP1_zdravstveno_osig_poslodavac_prva_isplata',15,4)->nullable();
            $table->float('ONEZR1_osiguranje_od_nezaposlenosti_radnik',15,4)->nullable();
            $table->float('UKSA_ukupni_sati_za_isplatu',15,4)->nullable();
            $table->float('olaksica',15,4)->nullable();
            $table->float('solid',15,4)->nullable();
            $table->float('PREK_prekovremeni',15,4)->nullable();
            $table->float('ISPLATA',15,4)->nullable();
            $table->float('UKUPNO',15,4)->nullable();

            $table->unsignedBigInteger('troskovno_mesto_id')->nullable(); // KADR sifra isplatnog mesta // Valjda ima MDR
            $table->unsignedBigInteger('organizaciona_celina_id')->nullable(); // KADR sifra isplatnog mesta // Valjda ima MDR


            $table->unsignedBigInteger('obracunski_koef_id')->nullable();
            $table->unsignedBigInteger('user_dpsm_id')->nullable(); // Mesec-Radnik-id
            $table->unsignedBigInteger('user_mdr_id')->nullable();

            $table->foreign('user_dpsm_id')->references('id')->on('mesecnatabelapoentazas');
            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas');
            $table->foreign('user_mdr_id')->references('id')->on('maticnadatotekaradnikas');

            $table->float('varijab',15,4)->nullable(); // Minuli rad
            $table->float('BMIN_prekovremeni_iznos',15,4)->nullable(); // prekovremeni iznos

            $table->float('UKIS_ukupan_iznos_za_izplatu')->nullable(); //Za isplatu rad iznos


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arhiva_sume_zara_po_radnikus');
    }
};
