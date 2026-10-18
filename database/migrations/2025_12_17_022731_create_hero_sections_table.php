<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_section', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('highlight_word_1_ar');
            $table->string('highlight_word_1_en');
            $table->string('subtitle_ar');
            $table->string('subtitle_en');
            $table->string('highlight_word_2_ar');
            $table->string('highlight_word_2_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('button_1_title_ar');
            $table->string('button_1_title_en');
            $table->string('button_1_link');
            $table->string('button_2_title_ar');
            $table->string('button_2_title_en');
            $table->string('button_2_link');
            $table->string('stat_1_number');
            $table->string('stat_1_title_ar');
            $table->string('stat_1_title_en');
            $table->string('stat_2_number');
            $table->string('stat_2_title_ar');
            $table->string('stat_2_title_en');
            $table->string('stat_3_number');
            $table->string('stat_3_title_ar');
            $table->string('stat_3_title_en');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_section');
    }
};
