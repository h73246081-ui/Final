<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    
    protected $table = 'website_settings';


    protected $fillable = [
        'site_name',
        'email',
        'phone',
        'contact',
        'direction_address',
        'direction_link',
        'facebook',
        'twitter',
        'instagram',
        'tiktok',
        'youtube',
        'linkedin',
        'address',
        'support_hours',
        'logo',
    ];
}
