<?php

namespace App\Http\Controllers\Publican;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:publican']);
    }

    public function index()
    {
        auth()->user()->pubs;
    }
}
