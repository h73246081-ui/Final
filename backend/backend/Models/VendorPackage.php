<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPackage extends Model
{
    protected $fillable=[
        'vendor_id','package_id','start_date','end_date','payment_method','amount','payment_intent_id','payment_status','status','product_added'
    ];
    // query scopes
    public function scopeActive($query){
        return $query->where('status','active')->where('end_date','>=',now());
    }
    public function scopePaid($query){
        return $query->where('payment_status','paid');
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
    public function package(){
        return $this->belongsTo(Package::class);
    }

    public function products()
    {
        return $this->hasMany(VendorProduct::class);
    }

}
