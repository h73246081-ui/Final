<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'user_id','order_number','first_name','last_name','email','phone','address','city','country','zipcode','payment_method','payment_intent_id',
        'payment_status', 'tax','discount','shipping','total_bill'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function vendorOrders(){
        return $this->hasMany(VendorOrder::class);
    }
    public function items(){
        return $this->hasMany(OrderItem::class);
    }



}
