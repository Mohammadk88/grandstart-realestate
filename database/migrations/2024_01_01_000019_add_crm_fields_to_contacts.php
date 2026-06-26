<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('status')->default('new')->after('is_read');
            // new | in_progress | converted | closed | spam
            $table->string('priority')->default('medium')->after('status');
            // low | medium | high | urgent
            $table->unsignedBigInteger('assigned_to')->nullable()->after('priority');
            $table->foreign('assigned_to')->references('id')->on('admins')->nullOnDelete();
            $table->text('crm_notes')->nullable()->after('notes');
            $table->timestamp('follow_up_at')->nullable()->after('crm_notes');
            $table->timestamp('last_action_at')->nullable()->after('follow_up_at');
            $table->unsignedBigInteger('last_action_by')->nullable()->after('last_action_at');
            $table->foreign('last_action_by')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropForeign(['last_action_by']);
            $table->dropColumn(['status', 'priority', 'assigned_to', 'crm_notes', 'follow_up_at', 'last_action_at', 'last_action_by']);
        });
    }
};
