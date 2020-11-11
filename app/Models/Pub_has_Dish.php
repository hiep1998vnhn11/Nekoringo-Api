<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pub_has_Dish extends Model
{
    use HasFactory;
    public function dish()
    {
        return $this->belongsTo('App\Models\Dish');
    }

    public function pub()
    {
        return $this->belongsTo('App\Models\Pub');
    }
}
