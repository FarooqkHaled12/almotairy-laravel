<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 50);
            $table->string('interest', 50)->nullable();
            $table->text('message')->nullable();
            $table->string('locale', 5)->default('ar');
            $table->string('status', 20)->default('new')->index();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['created_at', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
