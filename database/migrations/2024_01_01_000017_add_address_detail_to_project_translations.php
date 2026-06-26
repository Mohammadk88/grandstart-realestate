<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Move address_detail from projects to project_translations (translatable)
        Schema::table('project_translations', function (Blueprint $table) {
            $table->text('address_detail')->nullable()->after('location');
        });
        // Drop from projects table if exists
        if (Schema::hasColumn('projects', 'address_detail')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('address_detail');
            });
        }
        // Ensure district in projects is a key (already exists)
    }
    public function down(): void
    {
        Schema::table('project_translations', function (Blueprint $table) {
            $table->dropColumn('address_detail');
        });
    }
};
