<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreMessage extends Model
{
    protected $fillable=[
        'user_id','vendor_id','message','subject','reply'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
}
