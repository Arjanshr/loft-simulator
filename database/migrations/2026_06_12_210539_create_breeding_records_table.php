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
        Schema::create('breeding_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loft_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sire_id')->constrained('pigeons');
            $table->foreignId('dam_id')->constrained('pigeons');
            $table->timestamp('eggs_laid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breeding_records');
    }
};
