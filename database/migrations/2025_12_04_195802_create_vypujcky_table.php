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
        Schema::create('vypujcky', function (Blueprint $table) {
            $table->integer('vypujcka_id', true);
            $table->integer('uzivatel_id')->index('uzivatel_id');
            $table->integer('kopie_id')->index('kopie_id');
            $table->enum('status_pozadavku', ['ceka_na_schvaleni', 'schvaleno', 'zamitnuto', 'vraceno'])->default('ceka_na_schvaleni');
            $table->dateTime('datum_pozadavku')->useCurrent();
            $table->date('datum_schvaleni')->nullable();
            $table->date('planovane_datum_vraceni')->nullable();
            $table->date('skutecne_datum_vraceni')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vypujcky');
    }
};
