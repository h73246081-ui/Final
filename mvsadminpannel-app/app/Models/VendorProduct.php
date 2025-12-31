<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorProduct extends Model
{
       // Mass assignable fields
    protected $fillable = [
        'vendor_id',
        'category_id',
        'subcategory_id',
        'name',
        'description',
        'price',
        'discount',
        'stock',
        'image',
        'meta_title',
        'meta_description',
        'product_keyword',
        'sizes',   // json
        'color',   // json
        'specification'
    ];

    // Cast sizes to array
      // Cast JSON fields
    protected $casts = [
        'sizes' => 'array',
        'color' => 'array',
    ];

    // Relation to Vendor
    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    // Relation to Category
    public function category() {
        return $this->belongsTo(Category::class);
    }

 
    public function subcategory()
{
    return $this->belongsTo(SubCategory::class, 'subcategory_id'); // correct column name
}


    // Optional: Get price after discountC
    // public function getPriceAfterDiscountAttribute() {
    //     return $this->price - ($this->price * ($this->discount / 100));
    // }
}
