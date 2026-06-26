<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('address_detail', 255)->nullable()->after('district');
        });
    }
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('address_detail');
        });
    }
};
