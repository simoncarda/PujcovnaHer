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
        Schema::create('uzivatele', function (Blueprint $table) {
            $table->integer('uzivatel_id', true);
            $table->string('email')->unique('email');
            $table->string('password', 255);
            $table->string('name', 100)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uzivatele');
    }
};
