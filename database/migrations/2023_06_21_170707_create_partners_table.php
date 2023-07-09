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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->string('contact_employee');
            $table->string('pib');
            $table->string('phone');
            $table->string('web_site');
            $table->string('email');
            $table->string('sifra_delatnosti');
            $table->string('odgovorno_lice');
            $table->string('maticni_broj');
            $table->string('registarski_broj');
            $table->integer('mesto');
            $table->string('adress');
            $table->boolean('active');
            $table->string('internal_sifra')->unique();
            $table->boolean('pripada_pdvu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
