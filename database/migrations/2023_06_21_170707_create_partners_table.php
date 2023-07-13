<?php

use App\Enums\PartnerFields;
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
            $table->string(PartnerFields::FIELD_NAME->value);
            $table->string(PartnerFields::FIELD_SHORTNAME->value)->nullable();
            $table->string(PartnerFields::FIELD_CONTACT_EMPLOYEE->value)->nullable();
            $table->string(PartnerFields::FIELD_PIB->value);
            $table->string(PartnerFields::FIELD_PHONE->value)->nullable();
            $table->string(PartnerFields::FIELD_WEB_SITE->value)->nullable();
            $table->string(PartnerFields::FIELD_EMAIL->value)->nullable();
            $table->string(PartnerFields::FIELD_SIFRA_DELATNOSTI->value)->nullable();
            $table->string(PartnerFields::FIELD_ODGOVORNO_LICE->value)->nullable();
            $table->string(PartnerFields::FIELD_MATICNI_BROJ->value)->nullable();
            $table->integer(PartnerFields::FIELD_MESTO->value)->nullable();
            $table->string(PartnerFields::FIELD_ADDRESS->value)->nullable();
            $table->boolean(PartnerFields::FIELD_ACTIVE->value);
            $table->string(PartnerFields::FIELD_INTERNAL_SIFRA->value);
            $table->boolean(PartnerFields::FIELD_PRIPADA_PDVU->value);
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
