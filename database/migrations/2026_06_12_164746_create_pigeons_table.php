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
        Schema::create('pigeons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loft_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('speed')->default(10);
            $table->unsignedInteger('endurance')->default(10);
            $table->unsignedInteger('navigation')->default(10);
            $table->unsignedInteger('temperament')->default(10);
            $table->unsignedInteger('energy')->default(100);
            $table->string('status')->default('idle'); // idle, racing, resting
            $table->timestamp('last_trained_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pigeons');
    }
};
