<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            $uploadFolder = 'users/' . $user->id . '/profile_photo_image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
            Storage::disk('s3')->setVisibility($image_photo_path, 'public');
            $path = Storage::disk('s3')->url($image_photo_path);
            $user->profile_photo_path = $path;
        }
        $user->save();
        return $this->sendRespondSuccess($user, 'Update user successfully!');
    }
}
