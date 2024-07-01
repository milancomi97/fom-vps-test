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
        Schema::table('obrada_kreditis', function (Blueprint $table) {
            $table->unsignedBigInteger('kredit_glavna_tabela_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obrada_kreditis', function (Blueprint $table) {
            //
        });
    }
};
