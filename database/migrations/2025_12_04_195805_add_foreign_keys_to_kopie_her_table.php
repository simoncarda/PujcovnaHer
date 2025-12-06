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
        Schema::table('kopie_her', function (Blueprint $table) {
            $table->foreign(['hra_id'], 'kopie_her_ibfk_1')->references(['hra_id'])->on('hry')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kopie_her', function (Blueprint $table) {
            $table->dropForeign('kopie_her_ibfk_1');
        });
    }
};
