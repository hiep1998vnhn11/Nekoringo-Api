<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User')->select('name', 'id', 'email');
    }

    public function pub()
    {
        return $this->belongsTo('App\Models\Pub')->select('name', 'id');
    }
}
