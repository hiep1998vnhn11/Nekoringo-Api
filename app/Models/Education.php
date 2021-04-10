<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'tbl_extract_school_education_net';
    protected $fillable = [
        'school_name',
        'address',
        'tel',
        'fax',
        'notes'
    ];
    public $timestamps = false;
}
