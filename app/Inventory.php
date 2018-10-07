<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    public function category() {
        return $this->hasOne('App\Category','id','category_id');
    }
    public function categories() {
        return $this->hasMany('App\Category','id','category_id');
    }
}
