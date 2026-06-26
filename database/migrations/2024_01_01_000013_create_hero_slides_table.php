<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_tr')->nullable();
            $table->text('subtitle_ar')->nullable();
            $table->text('subtitle_en')->nullable();
            $table->text('subtitle_tr')->nullable();
            $table->string('btn_label_ar')->nullable();
            $table->string('btn_label_en')->nullable();
            $table->string('btn_label_tr')->nullable();
            $table->string('btn_url')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
