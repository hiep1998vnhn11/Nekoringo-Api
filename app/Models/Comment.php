<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User')->select('name', 'id', 'email', 'profile_photo_path');
    }

    public function pub()
    {
        return $this->belongsTo('App\Models\Pub')->select('name', 'id');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }
}
