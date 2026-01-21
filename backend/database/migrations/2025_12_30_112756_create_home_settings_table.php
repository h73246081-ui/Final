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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
                $table->string('badge')->nullable();       // e.g., "#1 Multi-Vendor Marketplace"
    $table->string('subtitle')->nullable();    // e.g., "Shop from"
    $table->string('title')->nullable();       // e.g., "Verified Vendors"
    $table->text('description')->nullable();   // e.g., "Discover thousands of products..."
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
