<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique(); // نوع الاستشارة

            // العنوان والوصف
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();

            // عنوان المميزات
            $table->string('feature_title_ar')->nullable();
            $table->string('feature_title_en')->nullable();

            // المميزات
            $table->json('features_ar')->nullable();
            $table->json('features_en')->nullable();

            // تفاصيل عامة
            $table->string('service_type_ar')->nullable();
            $table->string('service_type_en')->nullable();
            $table->string('session_duration_ar')->nullable();
            $table->string('session_duration_en')->nullable();
            $table->string('suitable_for_ar')->nullable();
            $table->string('suitable_for_en')->nullable();

            // نص المميزات
            $table->text('feature_text_ar')->nullable();
            $table->text('feature_text_en')->nullable();

            // الصورة
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
