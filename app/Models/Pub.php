<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pub extends Model
{
    use HasFactory;

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function has_dishes()
    {
        return $this->hasMany('App\Models\Pub_has_Dish');
    }
}
