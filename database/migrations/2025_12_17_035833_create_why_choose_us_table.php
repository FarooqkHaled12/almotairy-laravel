<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_choose_us', function (Blueprint $table) {
            $table->id();
            $table->string('highlight_word_ar')->nullable();
            $table->string('highlight_word_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();

            // النقاط الأربع
            for ($i = 1; $i <= 4; $i++) {
                $table->string("point_{$i}_title_ar")->nullable();
                $table->string("point_{$i}_title_en")->nullable();
                $table->text("point_{$i}_desc_ar")->nullable();
                $table->text("point_{$i}_desc_en")->nullable();
            }

            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_choose_us');
    }
};
