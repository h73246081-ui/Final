<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSocial extends Model
{
    //
        protected $fillable = [
        'icon',
        'name',
        'link',
        'color',
    ];
}
