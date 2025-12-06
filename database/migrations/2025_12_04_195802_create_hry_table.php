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
        Schema::create('hry', function (Blueprint $table) {
            $table->integer('hra_id', true);
            $table->string('nazev');
            $table->text('popis')->nullable();
            $table->integer('min_hracu')->nullable();
            $table->integer('max_hracu')->nullable();
            $table->integer('min_vek')->nullable();
            $table->string('url_obrazku', 512)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hry');
    }
};
