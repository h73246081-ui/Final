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
         Schema::create('vendor_products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('vendor_id')->constrained()->onDelete('cascade');

    // Category & SubCategory
    $table->unsignedBigInteger('category_id')->nullable();
    $table->unsignedBigInteger('subcategory_id')->nullable();

    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->decimal('discount', 10, 2)->default(0);
    $table->integer('stock')->default(0);
    $table->string('image')->nullable();

    // SEO fields
    $table->string('meta_title')->nullable();
    $table->string('meta_description')->nullable();
    $table->string('product_keyword')->nullable();
    $table->timestamps();

    // Foreign keys
    $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');
});
 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_products');
    }
};
