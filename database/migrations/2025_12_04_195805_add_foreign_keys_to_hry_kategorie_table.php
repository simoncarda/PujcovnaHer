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
        Schema::table('hry_kategorie', function (Blueprint $table) {
            $table->foreign(['hra_id'], 'hry_kategorie_ibfk_1')->references(['hra_id'])->on('hry')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['kategorie_id'], 'hry_kategorie_ibfk_2')->references(['kategorie_id'])->on('kategorie')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hry_kategorie', function (Blueprint $table) {
            $table->dropForeign('hry_kategorie_ibfk_1');
            $table->dropForeign('hry_kategorie_ibfk_2');
        });
    }
};
