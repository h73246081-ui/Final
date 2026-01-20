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
        Schema::table('vendor_packages', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_packages', 'card_number')) {
                $table->dropColumn(['card_number','cvv','name_on_card','expiry_date']);
            }

            // ➕ Add Stripe related fields
            if (!Schema::hasColumn('vendor_packages', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('amount');
            }
            if (!Schema::hasColumn('vendor_packages', 'start_date')) {
                $table->dateTime('start_date')->nullable();
            }
            if (!Schema::hasColumn('vendor_packages', 'end_date')) {
                $table->dateTime('end_date')->nullable();
            }

            if (!Schema::hasColumn('vendor_packages', 'payment_intent_id')) {
                $table->string('payment_intent_id')->nullable()->unique()->after('payment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_packages', function (Blueprint $table) {
            $table->string('card_number')->nullable();
            $table->string('cvv')->nullable();
            $table->string('name_on_card')->nullable();
            $table->date('expiry_date')->nullable();

            // 🔙 Remove added fields
            $table->dropColumn(['payment_status','payment_intent_id','start_date','end_date']);
        });
    }
};
