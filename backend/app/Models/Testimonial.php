<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    //
    protected $fillable = 
    [
        'name',
        'comments',
        'rating',
        'avatar', //image replace avatar
        'role',  // profession replace role
        'location'
    ];
}
