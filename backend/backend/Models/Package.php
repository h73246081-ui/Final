<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'package_name','price','duration','product_limit','commission_percent','status'
    ];
    public function vendorPackages(){
        return $this->hasMany(VendorPackage::class);
    }
}
