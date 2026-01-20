<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorStore extends Model
{
    //

        protected $fillable = [
        'vendor_id',
        'store_name',
        'slug',
        'email',
        'phone',
        'description',
        'address',
        'response_rate',
        'image',
        'status',
        'date',
    ];

    public function vendor()
{
    return $this->belongsTo(\App\Models\Vendor::class, 'vendor_id');
}

// VendorStore.php

public function vendorProducts()
{
    // Relation to VendorProduct based on vendor_id
    return $this->hasMany(\App\Models\VendorProduct::class, 'vendor_id', 'vendor_id');
}



}
