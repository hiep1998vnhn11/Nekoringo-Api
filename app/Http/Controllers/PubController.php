<?php

namespace App\Http\Controllers;

use App\Http\Requests\PubRequest;
use App\Models\Pub;
use Illuminate\Http\Request;

class PubController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function create(PubRequest $request)
    {
        $pub = new Pub();
        $pub->user_id = auth()->user()->id;
        $pub->name = $request->name;
        $pub->main_email = $request->main_email;
        $pub->phone_number = $request->phone_number;
        $pub->description = $request->description;
        $pub->save();
        $image_photo_path = null;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $uploadFolder = 'public/pubs/' . $pub->id . '/home_image/';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = env('APP_URL') . '/storage/' . $image->storeAs($uploadFolder, $imageName);
        }
        if ($image_photo_path) {
            $pub->home_photo_path = $image_photo_path;
            $pub->save();
        }
        return $this->sendRespondSuccess($pub, 'Create Pub successfully!');
    }

    public function delete(Pub $pub)
    {
        if ($pub->user_id != auth()->user()->id) return $this->sendForbidden();
        $pub->delete();
        return $this->sendRespondSuccess($pub, 'Deleted!');
    }

    public function show(Pub $pub)
    {
    }
}
