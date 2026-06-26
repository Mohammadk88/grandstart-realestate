<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('locale', 10);
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('location', 255)->nullable();
            $table->unique(['project_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_translations');
    }
};
