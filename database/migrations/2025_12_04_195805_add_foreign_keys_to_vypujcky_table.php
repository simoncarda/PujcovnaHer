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
        Schema::table('vypujcky', function (Blueprint $table) {
            $table->foreign(['uzivatel_id'], 'vypujcky_ibfk_1')->references(['uzivatel_id'])->on('uzivatele')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['kopie_id'], 'vypujcky_ibfk_2')->references(['kopie_id'])->on('kopie_her')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vypujcky', function (Blueprint $table) {
            $table->dropForeign('vypujcky_ibfk_1');
            $table->dropForeign('vypujcky_ibfk_2');
        });
    }
};
