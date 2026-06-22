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
        Schema::table('race_histories', function (Blueprint $table) {
            $table->string('race_type')->default('racing')->after('race_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('race_histories', function (Blueprint $table) {
            $table->dropColumn('race_type');
        });
    }
};
