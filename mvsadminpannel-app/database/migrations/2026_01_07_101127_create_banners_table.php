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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('shop_heading');
            $table->longText('shop_text');
            $table->string('vendor_heading');
            $table->longText('vendor_text');
            $table->string('contact_heading');
            $table->longText('contact_text');
            $table->string('about_heading');
            $table->longText('about_text');
            $table->string('blog_heading');
            $table->string('term_heading');
            $table->longText('term_text');
            $table->string('privacy_heading');
            $table->longText('privacy_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
