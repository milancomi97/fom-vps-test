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

            $table->foreign('user_dpsm_id')->references('id')->on('mesecnatabelapoentazas')->onDelete('cascade');
            $table->foreign('obracunski_koef_id')->references('id')->on('datotekaobracunskihkoeficijenatas')->onDelete('cascade');
            $table->foreign('user_mdr_id')->references('id')->on('maticnadatotekaradnikas')->onDelete('cascade');

//            $table->integer('varijab_')->nullable();
//            $table->integer('bmin_')->nullable();

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
