<?php

namespace App\Http\Controllers;

use App\Http\Requests\PubRequest;
use App\Models\Pub;
use Illuminate\Support\Str;
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
        $pub->business_time = $request->business_time;
        $pub->map_path = $request->map_path;
        $pub->video_path = $request->video_path;
        $pub->home_photo_path = 'https://www.événementiel.net/wp-content/uploads/2014/02/default-placeholder.png';
        $pub->save();
        $image_photo_path = null;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $uploadFolder = 'public/pubs/' . $pub->id . '/home_image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs($uploadFolder, $imageName);
            $image_photo_path = env('APP_URL') . '/storage/' . Str::after($path, 'public/');
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

    public function get(Pub $pub)
    {
        return $this->sendRespondSuccess($pub, 'Get successfully!');
    }
}
