<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable=[
        'shop_heading','shop_text','vendor_heading','vendor_text','contact_heading','contact_text','about_heading','about_text','blog_heading',
        'term_heading','term_text','privacy_heading','privacy_text'
    ];
}
