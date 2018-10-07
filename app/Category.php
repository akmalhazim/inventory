<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public function subCategories() {
        return $this->hasMany('App\SubCategory', 'parent_category_id');
    }
    public function subCategory() {
        return $this->hasOne('App\SubCategory', 'parent_category_id');
    }
}
