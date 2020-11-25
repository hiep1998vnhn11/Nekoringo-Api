<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin', ['expect' => ['login']]);
    }

    public function login()
    {
        return view('welcome');
    }
}
