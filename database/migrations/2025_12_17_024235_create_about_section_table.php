<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_section', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title_1_ar');
            $table->string('title_1_en');
            $table->string('title_2_ar');
            $table->string('title_2_en');
            $table->longText('description_ar');
            $table->longText('description_en');
            $table->text('features_ar'); // نخزنها كـ JSON
            $table->text('features_en');
            $table->string('signature_ar');
            $table->string('signature_en');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_section');
    }
};
