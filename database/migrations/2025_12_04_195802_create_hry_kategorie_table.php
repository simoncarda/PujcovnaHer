<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hry_kategorie', function (Blueprint $table) {
            $table->integer('hra_id');
            $table->integer('kategorie_id')->index('kategorie_id');

            $table->primary(['hra_id', 'kategorie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hry_kategorie');
    }
};
