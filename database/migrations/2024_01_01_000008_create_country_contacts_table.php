<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 10)->nullable()->unique();
            $table->string('country_name_ar', 100);
            $table->string('country_name_en', 100);
            $table->string('flag_emoji', 10)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('currency_code', 10)->default('USD');
            $table->string('currency_symbol', 10)->default('$');
            $table->string('price_field', 30)->default('price_usd');
            $table->boolean('is_default')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_contacts');
    }
};
