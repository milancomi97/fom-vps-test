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

        //            "MBRD,C,7"             Maticni broj
//,"RBIM,C,3"            Sifra isplatnog mesta - banke
//,"RBTC,C,8"            Sifra troskovnog mesta
//,"SSZNE,N,5,1"         SSZNE - SUMA SATI ZARADE
//,"SIZNE,N,16,2"        Ukupni iznos zarade
//"SSNNE,N,5,1",         // Suma SATI Naknade, bolovanja
//"SINNE,N,16,2"         // Ukupni Iznos Naknade, bolovanja

//"IZNETO,N,16,2",       // zbir ukupni iznos zarade + ukupni iznos Naknade
//,"SID,N,16,2"          // Ukupni iznos doprinosa ( penzijsko, zdravstve i nezaposlenost)
//,"SIP,N,16,2"        // Ukupni iznos poreza
//"SIOB,N,16,2"        // Ukupni iznos obustava, fiksna placanja
//,"EFSATI,N,12,2",    // Ukupni efektivni sati DVPL->EFSA ako bude D, akumuliraju sati u ovom polju
//"AKONT,N,14,2"       // Iznos primljene akontacije
//,"NEAK,N,12,2",      // Neopravdana akontacija, greskom nastaje
//"ZARKR,N,14,2"       // Ukupni zbir kredita
//"EFIZNO,N,12,2"    // Kumulativ iznosa za efektivne sate
//"RBPS,C,2",           // strucna sprema
//"MINIM,N,12,2",    // Minimalna zarada
        //            PRIZ
//PRCAS
//"RBOP,C,4",       // sifra opstine
//"TOPLI,N,10,2",   // Topli obrok 019 iznos
//"TOPSATI,N,10,2"  // Topli obrok 019 sati
//"PRIZ,N,10,2"     // Prosecni iznos zarade za prethodnih 12 meseci
//,"PRCAS,N,6,1"    //Prosecni broj sati za prethodnih 12 meseci
//        "KOREKC,N,12,2"   // Dotacija to minimalne bruto zarade
//,"REGRES,N,10,2", // Iznos regresa
//"POROSL,N,10,2"   // Poresko oslobodjenje
//,"PREZIME,C,15"   // prezime
//,"IME,C,10",      // ime
//"SREDIME,C,2",   // srednje ime
//"LBG,C,13",      // jmbg
//"GGST,N,2,0"     // Godine staza
//,"MMST,N,2,0",  // Meseci staza
//,"RBRM,C,3"     // Redni broj radnog mesta

        //            "NETO,N,12,2",    // Neto zarada, kada se sve sto je gore odbije (gore je bruto)
//"IZNETO1,N,12,2", // Prva isplata (akontacija)
//"SIP1,N,12,2",   // Porez prva isplata
//"BROSN,N,12,2"   // Osnovica za doprinose
//,"BROSN1,N,12,2", // Osnovnica za doprinose za prvu isplatu
//"PIOR,N,12,2"     // Penzijsko osiguranje na teret radnika
//,"ZDRR,N,12,2",   // Zdravstveno osiguranje na teret radnika
//"ONEZR,N,12,2",   // Osiguranje od nezaposlenosti teret radnika
//"PIOP,N,12,2", // Penzijsko osiguranje na teret poslodavca
//"ZDRP,N,12,2", // Zdravstveno osiguranje na teret poslodavca
//,"ZRAC,C,25",  // Tekuci racun
//"POROSL1,N,12,2"   // Poresko oslobodjenje za prvu isplatu
//,"PIOR1,N,12,2"    // Penzijsko osiguranje na teret radnik kod prve isplate
//,"PIOP1,N,12,2",   // Penzijsko osig na teret poslodavca kod prve isplate
//"ZDRR1,N,12,2",    // Zdravstveno radnik prva ispl
//"ZDRP1,N,12,2",    // Zdravstveno poslodavac prva ispl
//"ONEZR1,N,12,2"    // Osiguranje od nezaposlenosti na teret radnika
//,"UKSA,N,5,1"      // Ukupan iznos za isplatu
        Schema::create('obrada_zara_po_radnikus', function (Blueprint $table) {
            $table->id();
            $table->string('maticni_broj')->nullable();
            $table->integer('rbim_sifra_isplatnog_mesta')->nullable();
            $table->integer('sifra_troskovnog_mesta')->nullable();
            $table->integer('SSZNE_suma_sati_zarade')->nullable();
            $table->integer('SIZNE_ukupni_iznos_zarade')->nullable();

            $table->integer('SSNNE_suma_sati_naknade')->nullable(); // bolovanja
            $table->integer('SINNE_ukupni_iznos_naknade')->nullable(); // bolovanja

            $table->integer('IZNETO_zbir_ukupni_iznos_naknade_i_naknade')->nullable(); //

            $table->integer('SID_ukupni_iznos_doprinosa')->nullable(); //  ( penzijsko, zdravstve i nezaposlenost)
            $table->integer('SIP_ukupni_iznos_poreza')->nullable(); //  fiksna p

            $table->integer('SIOB_ukupni_iznos_obustava')->nullable(); // fiksna placanja
            $table->integer('EFSATI_ukupni_iznos_efektivnih_sati')->nullable(); // DVPL->EFSA ako bude D

            $table->integer('AKONT_iznos_primljene_akontacije')->nullable();
            $table->integer('NEAK_neopravdana_akontacija')->nullable();
            $table->integer('ZARKR_ukupni_zbir_kredita')->nullable();

            $table->integer('EFIZNO_kumulativ_iznosa_za_efektivne_sate')->nullable();
            $table->integer('RBPS_strucna_sprema')->nullable();

            $table->integer('MINIM_minimalna_zarada')->nullable();

            $table->integer('RBOP_sifra_opstine')->nullable();

            $table->integer('TOPLI_obrok_iznos')->nullable(); // 019
            $table->integer('TOPLI_obrok_sati')->nullable(); // 019


            $table->integer('PRIZ_prosecni_iznos_godina')->nullable();
            $table->integer('PRIZ_prosecni_sati_godina')->nullable();


            $table->integer('KOREKC_dotacija_za_minimalnu_bruno_osnovicu')->nullable();

            $table->integer('REGRES_iznos_regresa')->nullable();
            $table->integer('POROSL_poresko_oslobodjenje')->nullable();

            $table->integer('ime')->nullable();
            $table->integer('prezime')->nullable();
            $table->integer('srednje_ime')->nullable();
            $table->integer('LBG_jmbg')->nullable();

            $table->integer('GGST_godine_staza')->nullable();
            $table->integer('MMST_meseci_staza')->nullable();

            $table->integer('RBRM_redni_broj_radnog_mesta')->nullable();

            $table->integer('NETO_neto_zarada')->nullable(); // kada se sve sto je gore odbije (gore je bruto)
            $table->integer('IZNETO1_prva_isplata_akontacija')->nullable();
            $table->integer('SIP1_porez_prva_isplata')->nullable();

            $table->integer('BROSN_osnovica_za_doprinose')->nullable();
            $table->integer('BROSN1_osnovica_za_doprinose_prva_isplata')->nullable();

            $table->integer('PIOR_penzijsko_osiguranje_na_teret_radnika')->nullable();

            $table->integer('ZDRR_zdravstveno_osiguranje_na_teret_radnika')->nullable();

            $table->integer('ONEZR_osiguranje_od_nezaposlenosti_teret_radnika')->nullable();
            $table->integer('PIOP_penzijsko_osiguranje_na_teret_poslodavca')->nullable();


            $table->integer('ZDRP_zdravstveno_osiguranje_na_teret_poslodavca')->nullable();
            $table->integer('ZRAC_tekuci_racun')->nullable();

            $table->integer('POROSL1_poresko_oslobodjenje_za_prvu_isplatu')->nullable();
            $table->integer('PIOR1_penzijsko_osiguranje_radnik_prva_isplata')->nullable();
            $table->integer('PIOP1_penzijsko_osiguranje_poslodavac_prva_isplata')->nullable();

            $table->integer('ZDRR1_zdravstveno_osig_radnik_prva_isplata')->nullable();
            $table->integer('ZDRP1_zdravstveno_osig_poslodavac_prva_isplata')->nullable();
            $table->integer('ONEZR1_osiguranje_od_nezaposlenosti_radnik')->nullable();
            $table->integer('UKSA_ukupan_iznos_za_isplatu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obrada_zara_po_radnikus');
    }
};
