<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table = 'borrower';

    public function user() {
        return $this->hasOne('App\User', 'unique_number','user_id');
    }
}
