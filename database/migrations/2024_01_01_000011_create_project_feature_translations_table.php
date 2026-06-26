<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_feature_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')->constrained('project_features')->cascadeOnDelete();
            $table->string('locale', 10);
            $table->string('text', 255);
            $table->unique(['feature_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_feature_translations');
    }
};
