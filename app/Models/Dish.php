<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    public function has_pubs()
    {
        return $this->hasMany('App\Models\Pub_has_Dish');
    }
}
