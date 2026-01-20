<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestSeller extends Model
{
    //
     
    protected $table = 'best_sellers';


    protected $fillable = [
        'vendor_product_id'
    ];

   
    public function product()
    {
        return $this->belongsTo(VendorProduct::class, 'vendor_product_id');
    }
}
