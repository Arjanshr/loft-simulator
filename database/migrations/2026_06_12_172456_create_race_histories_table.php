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
        Schema::create('race_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loft_id')->constrained()->cascadeOnDelete();
            $table->string('race_title');
            $table->string('pigeon_name');
            $table->unsignedInteger('position');
            $table->unsignedBigInteger('payout')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_histories');
    }
};
