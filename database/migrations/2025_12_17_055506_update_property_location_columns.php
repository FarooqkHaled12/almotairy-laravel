<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'location_url')) {
                $table->dropColumn('location_url');
            }
            $table->string('location_ar')->nullable();
            $table->string('location_en')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['location_ar', 'location_en']);
            $table->string('location_url')->nullable();
        });
    }
};
