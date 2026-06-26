<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->unique()->after('id');
            $table->string('budget_range')->nullable()->after('message');
            $table->string('preferred_contact')->default('any')->after('budget_range');
            // any | whatsapp | call | email
            $table->string('language')->nullable()->after('preferred_contact');
            // ar | en | tr | ru ...
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['contact_number', 'budget_range', 'preferred_contact', 'language']);
        });
    }
};
