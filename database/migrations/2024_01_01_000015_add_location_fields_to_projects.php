<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('country', 100)->nullable()->after('longitude');
            $table->string('city', 100)->nullable()->after('country');
            $table->string('district', 150)->nullable()->after('city');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['country', 'city', 'district']);
        });
    }
};
