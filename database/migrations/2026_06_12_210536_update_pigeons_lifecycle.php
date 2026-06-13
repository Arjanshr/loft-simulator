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
            $table->timestamp('birth_at')->nullable();
            $table->timestamp('hatch_at')->nullable();
            $table->foreignId('sire_id')->nullable()->constrained('pigeons');
            $table->foreignId('dam_id')->nullable()->constrained('pigeons');
        });
    }

    public function down(): void
    {
        Schema::table('pigeons', function (Blueprint $table) {
            $table->dropForeign(['sire_id']);
            $table->dropForeign(['dam_id']);
            $table->dropColumn(['birth_at', 'hatch_at', 'sire_id', 'dam_id']);
        });
    }
};
