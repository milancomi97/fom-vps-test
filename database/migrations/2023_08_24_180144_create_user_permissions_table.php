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
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('osnovni_podaci')->default(false);
            $table->boolean('finansijsko_k')->default(false);
            $table->boolean('materijalno_k')->default(false);
            $table->boolean('pogonsko')->default(false);
            $table->boolean('magacini')->default(false);
            $table->boolean('osnovna_sredstva')->default(false);
            $table->boolean('kadrovska_evidencija')->default(false);
            $table->boolean('obracun_zarada')->default(false);
            $table->boolean('tehnologija')->default(false);
            $table->boolean('proizvodnja')->default(false);
            $table->string('role_name')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};
