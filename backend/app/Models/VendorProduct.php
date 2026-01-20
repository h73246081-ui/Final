<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorProduct extends Model
{
       // Mass assignable fields
    protected $fillable = [
        'vendor_id',
        'vendor_package_id',
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
        'image'=>'array'
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
    public function items(){
        return $this->hasMany(OrderItem::class,'product_id','id');
    }
    public function vendorReview(){
        return $this->hasMany(VendorReview::class);
    }
    public function vendorPackage()
    {
        return $this->belongsTo(VendorPackage::class);
    }

    // Optional: Get price after discountC
    // public function getPriceAfterDiscountAttribute() {
    //     return $this->price - ($this->price * ($this->discount / 100));
    // }
}
