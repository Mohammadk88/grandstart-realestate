<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_contact_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_contact_id')->constrained('country_contacts')->cascadeOnDelete();
            $table->string('locale', 10);
            $table->text('address');
            $table->unique(['country_contact_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_contact_addresses');
    }
};
