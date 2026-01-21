<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'city',
        'country',
        'address',
        'ntn_number',
        'cnic_number',
        'cnic_front',
        'cnic_back',
        'bank_name',
        'bank_account',

        'seller_type',
        'verification_status',
        'verification_remarks',
        'verified_at',
        'verification_requested_at',
        'status'
    ];
    public function vendorStore(){
        return $this->hasOne(VendorStore::class);
    }
    public function vendorPolicies(){
        return $this->hasMany(Vendor::class);
    }

        public function user(){
        return $this->belongsTo(User::class);
    }

        public function products()
    {
        return $this->hasMany(VendorProduct::class);
    }
    public function vendorOrders()
    {
        return $this->hasMany(VendorOrder::class);
    }
    public function storeMessage(){
        return $this->hasMany(StoreMessage::class);
    }
    public function vendorPackages(){
        return $this->hasMany(VendorPackage::class);
    }

}
