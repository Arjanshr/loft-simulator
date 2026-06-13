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
            $table->decimal('eyes', 5, 2)->default(1)->change();
            $table->decimal('beak', 5, 2)->default(1)->change();
            $table->decimal('legs', 5, 2)->default(1)->change();
            $table->decimal('feather_quality', 5, 2)->default(1)->change();
            $table->decimal('pattern', 5, 2)->default(1)->change();
            $table->decimal('color', 5, 2)->default(1)->change();
            $table->decimal('purity', 5, 2)->default(1)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pigeons', function (Blueprint $table) {
            $table->unsignedInteger('eyes')->default(1)->change();
            $table->unsignedInteger('beak')->default(1)->change();
            $table->unsignedInteger('legs')->default(1)->change();
            $table->unsignedInteger('feather_quality')->default(1)->change();
            $table->unsignedInteger('pattern')->default(1)->change();
            $table->unsignedInteger('color')->default(1)->change();
            $table->unsignedInteger('purity')->default(1)->change();
        });
    }
};
