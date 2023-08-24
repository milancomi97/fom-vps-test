<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });


        Schema::create('materijals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sifra_materijala')->nullable();
            $table->string('naziv_materijala')->nullable();
            $table->string('standard')->nullable();
            $table->string('dimenzija')->nullable();
            $table->string('kvalitet')->nullable();
            $table->string('jedinica_mere')->nullable();
            $table->integer('tezina')->nullable();
            $table->string('dimenzije')->nullable();
            $table->string('dimenzija_1')->nullable();
            $table->string('dimenzija_2')->nullable();
            $table->string('dimenzija_3')->nullable();
            $table->string('dimenzija_4')->nullable();
            $table->unsignedBigInteger('sifra_standarda')->nullable();
            $table->string('napomena')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materijals');
        Schema::dropIfExists('categories');
    }
};
