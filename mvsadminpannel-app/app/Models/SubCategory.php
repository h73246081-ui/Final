<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

     protected $table = 'subcategories'; // 👈 FIXs

    //
        protected $fillable = [
        'category_id',
        'name',
        'description',
        'slug', // <- add this
        'question_description',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function products()
{
    return $this->hasMany(VendorProduct::class, 'subcategory_id'); // correct column name
}



}
