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
            $table->foreignId('stray_at_loft_id')->nullable()->constrained('lofts')->nullOnDelete();
            $table->timestamp('lost_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pigeons', function (Blueprint $table) {
            $table->dropForeign(['stray_at_loft_id']);
            $table->dropColumn(['stray_at_loft_id', 'lost_at']);
        });
    }
};
