<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('preferred_location')->nullable()->after('preferred_visit_at');
            $table->foreignId('preferred_category_id')->nullable()->after('preferred_location')->constrained('property_categories')->nullOnDelete();
            $table->unsignedBigInteger('budget_min')->nullable()->after('preferred_category_id');
            $table->unsignedBigInteger('budget_max')->nullable()->after('budget_min');
            $table->unsignedInteger('area_min')->nullable()->after('budget_max');
            $table->unsignedInteger('area_max')->nullable()->after('area_min');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign(['preferred_category_id']);
            $table->dropColumn([
                'preferred_location',
                'preferred_category_id',
                'budget_min',
                'budget_max',
                'area_min',
                'area_max',
            ]);
        });
    }
};
