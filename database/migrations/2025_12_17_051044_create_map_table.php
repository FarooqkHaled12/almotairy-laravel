<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('map', function (Blueprint $table) {
            $table->id();
            $table->text('map_embed')->nullable(); // كود التضمين (iframe)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('map');
    }
};
