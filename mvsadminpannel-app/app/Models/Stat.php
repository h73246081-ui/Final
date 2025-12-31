<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    //
    
    protected $table = 'stats';

    // Mass assignable fields
    protected $fillable = [
        'icon',
        'value',
        'suffix',
        'label',
        'color',
    ];
}
