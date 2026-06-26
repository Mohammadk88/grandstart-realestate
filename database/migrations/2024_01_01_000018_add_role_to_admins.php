<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('role')->default('super_admin')->after('active');
            $table->string('phone')->nullable()->after('email');
            $table->timestamp('last_login_at')->nullable()->after('role');
        });

        // Make the first admin super_admin
        DB::table('admins')->where('id', 1)->update(['role' => 'super_admin']);
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'last_login_at']);
        });
    }
};
