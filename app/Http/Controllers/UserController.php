<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function update(UpdateUserRequest $request)
    {
        $user = auth()->user();
        if ($request->name) {
            $user->name = $request->name;
        }
        if ($request->phone_number) {
            $user->phone_number = $request->phone_number;
        }
        if ($request->hasFile('image')) {
            $image = $request->image;
            $uploadFolder = 'public/users/' . $user->id . '/profile_photo';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs($uploadFolder, $imageName);
            $image_photo_path = env('APP_URL') . '/storage/' . Str::after($path, 'public/');
            $user->profile_photo_path = $image_photo_path;
        }
        $user->save();
        return $this->sendRespondSuccess($user, 'Update user successfully!');
    }
}
