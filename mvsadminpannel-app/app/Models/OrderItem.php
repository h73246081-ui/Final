<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable=[
       'order_id', 'vendor_order_id','product_id','product_name','quantity','price','tax','discount','total','color','image','size',  'commission_percent',
       'commission_amount',
       'vendor_amount'
    ];
    public function vendorOrder(){
        return $this->belongsTo(VendorOrder::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function vendorproduct(){
        return $this->belongsTo(VendorProduct::class,'product_id','id');
    }
}
