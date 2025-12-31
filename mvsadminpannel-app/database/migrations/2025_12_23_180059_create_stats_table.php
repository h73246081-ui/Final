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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('icon');       // Icon name
            $table->string('value');      // Could be text like "100K" or "4.8"
            $table->string('suffix')->nullable(); // +, *, etc.
            $table->string('label');      // Label of the stat
            $table->string('color');      // Tailwind gradient classes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
