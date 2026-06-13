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
        Schema::table('pigeons', function (Blueprint $table) {
            $table->unsignedInteger('level')->default(1);
            $table->string('type')->default('racer'); // fancy, racer, highflyer
            $table->unsignedInteger('beauty')->default(1);
            $table->string('rarity')->default('common'); // common, rare, legendary
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pigeons', function (Blueprint $table) {
            $table->dropColumn(['level', 'type', 'beauty', 'rarity']);
        });
    }
};
