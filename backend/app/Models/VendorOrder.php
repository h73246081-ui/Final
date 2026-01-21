<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorOrder extends Model
{
    protected $fillable=[
        'order_id','vendor_id','vendor_subtotal','vendor_tax','vendor_discount','vendor_shipping','vendor_total','status'
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
