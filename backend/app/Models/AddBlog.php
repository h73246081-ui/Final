<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddBlog extends Model
{
    //
    protected $fillable = [
        'title',
        'author',
        'author_image',
        'date',
        'image',
        'description',
    ];
}
