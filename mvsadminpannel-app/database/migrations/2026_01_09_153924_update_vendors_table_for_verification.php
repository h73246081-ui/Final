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
        Schema::table('vendors', function (Blueprint $table) {

                if (Schema::hasColumn('vendors', 'store_name')) {
                    $table->dropColumn('store_name');
                }
                if (Schema::hasColumn('vendors', 'image')) {
                    $table->dropColumn('image');
                }
                if (Schema::hasColumn('vendors', 'address')) {
                    $table->dropColumn('address');
                }
                if (Schema::hasColumn('vendors', 'phone')) {
                    $table->dropColumn('phone');
                }
                if (Schema::hasColumn('vendors', 'status')) {
                    $table->dropColumn('status');
                }
                $table->string('name')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->nullable();
                $table->string('address')->nullable();
                $table->string('ntn_number',100)->nullable()->after('user_id');
                $table->string('cnic_number',100)->nullable();
                $table->string('cnic_front')->nullable();
                $table->string('cnic_back')->nullable();
                $table->string('bank_name')->nullable();
                $table->string('bank_account',100)->nullable();

                $table->enum('seller_type', ['private', 'business'])
                      ->default('private');
                $table->text('verification_remarks')->nullable();
                $table->string('status')->nullable()->default('pending');
                $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn([
                'ntn_number',
                'cnic_number',
                'cnic_front',
                'cnic_back',
                'bank_name',
                'bank_account',
                'seller_type',
                'verification_remarks',
                'verified_at',
                'name',
                'city',
                'address',
                'country',
                'status'
            ]);
        });
    }
};
