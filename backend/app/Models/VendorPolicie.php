<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPolicie extends Model
{
    protected $fillable=[
        'title','content','vendor_id'
    ];
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
}
