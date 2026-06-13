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
            $table->dropColumn('beauty');
            $table->unsignedInteger('eyes')->default(1);
            $table->unsignedInteger('beak')->default(1);
            $table->unsignedInteger('legs')->default(1);
            $table->unsignedInteger('feather_quality')->default(1);
            $table->unsignedInteger('pattern')->default(1);
            $table->unsignedInteger('color')->default(1);
            $table->unsignedInteger('purity')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('pigeons', function (Blueprint $table) {
            $table->unsignedInteger('beauty')->default(1);
            $table->dropColumn(['eyes', 'beak', 'legs', 'feather_quality', 'pattern', 'color', 'purity']);
        });
    }
};
