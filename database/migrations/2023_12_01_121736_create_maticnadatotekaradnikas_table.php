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
            $table->string('maticni_broj');
            $table->string('prezime');
            $table->string('ime');
            $table->unsignedBigInteger('radno_mesto'); // sifra radnog mesta
            $table->unsignedBigInteger('isplatno_mesto'); // sifra isplatnog mesta // NOVO DODATO
            $table->string('tekuci_racun')->nullable();
            $table->string('redosled_poentazi');
            $table->unsignedBigInteger('vrsta_rada'); // IZMENIO NAZIV
            $table->unsignedBigInteger('oblik_rada');
            $table->string('radna_jedinica')->nullable();
            $table->string('brigada')->nullable();
            $table->string('godine_staza');
            $table->string('meseci_staza');
            $table->boolean('minuli_rad_aktivan'); // D tačno
            $table->boolean('prebacaj'); // 1 default
            $table->unsignedBigInteger('stvarna_strucna_sprema');
            $table->unsignedBigInteger('priznata_strucna_sprema');
            $table->string('osnovna_zarada');
            $table->string('prethodna_osnovna_zarada'); // Novo dodato
            $table->string('jmbg');
            $table->boolean('pol');
            $table->string('ukupni_sati');
            $table->string('ukupan_iznos');
            $table->string('broj_meseci_za_obracun'); // broj meseci znacajan za obracun proseka
            $table->string('kalendarski_dani'); // broj meseci znacajan za obracun proseka
            $table->string('bruto_zarada_za_akontaciju'); // IZNETO1
            $table->string('poresko_oslobodjenje_za_akontaciju'); // POROSL1,N,12,2
            $table->string('porez_za_akontaciju'); // SIP1,N,12,2
            $table->string('minimalna_osnovica_za_obracun_dobrinosa_za_akontaciju'); // BROSN1,N,12,2
            $table->string('pio_dobrinos_na_teret_radnika_za_akontaciju'); // PIOR1,N,12,2
            $table->string('pio_dobrinos_na_teret_poslodavca_za_akontaciju'); // PIOP1,N,12,2
            $table->string('zdravstveno_osiguranje_na_teret_radnika_za_akontaciju'); // ZDRR1,N,12,2
            $table->string('zdravstveno_osiguranje_na_teret_poslodavca_za_akontaciju'); // ZDRP1,N,12,2
            $table->string('osiguranje_od_nezaposlenosti_na_teret_radnika_za_akontaciju'); // ONEZR1,N,12,2
            $table->string('ukupni_pio_doprinos_na_teret_radnika'); // PIOR,N,12,2
            $table->string('ukupni_pio_doprinos_na_teret_poslodavca'); // PIOP,N,12,2
            $table->string('ukupni_doprinos_za_nezaposlenost_na_teret_radnika'); // ZDRR,N,12,2
            $table->string('ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_radnika'); // ZDRR,N,12,2
            $table->string('ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_poslodavca'); // ZDRP,N,12,2
            $table->string('bruto_zarada_za_obracun_doprinosa'); // BROSN,N,12,2
            $table->string('poresko_oslobodjenje'); // POROSL,N,12,2
            $table->string('ukupni_porezi'); // SIP,N,12,2
            $table->string('bruto_zarada'); // IZNETO,N,12,2



            $table->unsignedBigInteger('opstina_id'); // sifra opstine 4 broja
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
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
