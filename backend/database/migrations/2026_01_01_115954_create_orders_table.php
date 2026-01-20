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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->longText('address');
            $table->string('city');
            $table->string('country');
            $table->string('zipcode');
            $table->string('order_number', 100)->nullable();
            $table->decimal('tax',65,2)->nullable();
            $table->decimal('discount',65,2)->nullable();
            $table->decimal('shipping',65,2)->nullable();
            $table->decimal('total_bill',65,2);
            // $table->string('payment_status')->nullable();
            // $table->string('status')->nullable();
            $table->string('payment_method');
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
