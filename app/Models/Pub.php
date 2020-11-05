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

    public function dishes()
    {
        return $this->hasMany('App\Models\Dish');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
