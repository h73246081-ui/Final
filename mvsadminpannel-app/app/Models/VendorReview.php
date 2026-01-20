<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorReview extends Model
{
    protected $fillable=[
        'product_id','user_id','title','comment','rating','status'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function vendorProduct(){
        return $this->belongsTo(VendorProduct::class,'product_id','id');
    }
}
