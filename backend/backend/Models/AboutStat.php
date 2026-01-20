<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutStat extends Model
{
    
    protected $fillable = [
        'icon',
        'value',
        'suffix',
        'label',
        'color',
    ];
}
