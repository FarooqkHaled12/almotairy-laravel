<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cta', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('button_1_text_ar')->nullable();
            $table->string('button_1_text_en')->nullable();
            $table->string('button_1_link')->nullable();
            $table->string('button_2_text_ar')->nullable();
            $table->string('button_2_text_en')->nullable();
            $table->string('button_2_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cta');
    }
};
