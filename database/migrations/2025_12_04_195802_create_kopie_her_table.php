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
        Schema::create('kopie_her', function (Blueprint $table) {
            $table->integer('kopie_id', true);
            $table->integer('hra_id')->index('hra_id');
            $table->enum('stav', ['dostupna', 'nedostupna'])->default('dostupna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kopie_her');
    }
};
