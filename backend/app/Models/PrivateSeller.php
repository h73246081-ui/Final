<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateSeller extends Model
{
    protected $fillable=[
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
