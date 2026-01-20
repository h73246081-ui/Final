<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
        protected $fillable = [
        'name',
        'description',
        'question_description',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'image',
         'color'
    ];

        public function SubCategory()
    {
        return $this->hasMany(SubCategory::class);
    }

      public function products()
    {
        return $this->hasMany(VendorProduct::class, 'category_id');
    }
}
