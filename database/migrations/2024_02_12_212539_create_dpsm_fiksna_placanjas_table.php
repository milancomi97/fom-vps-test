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
        Schema::create('dpsm_fiksna_placanjas', function (Blueprint $table) {
            $table->id();
//            MBRD,C,7	RBVP,C,3	SLOV,C,1	SATI,N,5,1	IZNO,N,10,2	PERC,N,6,2	DATUM,D	POK2,C,1	RBMZ,C,4	RBOP,C,4	STATUS,C,1

            $table->string('maticni_broj');
            $table->string('sifra_vrste_placanja');
            $table->string('SLOV_grupa_vrste_placanja');
            $table->integer('sati')->nullable();
            $table->integer('iznos')->nullable();
            $table->integer('procenat')->nullable();
            $table->integer('status')->nullable();
            $table->string('POK2_obracun_minulog_rada')->nullable();
            $table->string('datum');
            $table->string('RBMZ'); // Ovo skini
            $table->string('RBOP'); // Opstina, ovo skini

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpsm_fiksna_placanjas');
    }
};
