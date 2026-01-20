<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashDeal extends Model
{
    //
        protected $fillable = [
        'title',
        'description',
        'category_id',
        'product_id',
        'discount',
        'start_at',
        'end_at',
        'is_active',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function product() {
        return $this->belongsTo(VendorProduct::class, 'product_id');
    }

    

}
