<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Str;

class AuthController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('role:admin', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        if (!Str::contains($request->email, 'admin')) {
            return $this->sendForbidden();
        }
        $credentials = request(['email', 'password']);
        if (!$token = auth()->setTTL(7200)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return $this->sendRespondSuccess(auth()->user(), 'Post!');
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
