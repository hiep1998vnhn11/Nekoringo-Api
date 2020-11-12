<?php

namespace App\Http\Controllers;

use App\Http\Requests\PubRequest;
use App\Http\Requests\UpdatePubRequest;
use App\Models\Pub;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PubController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['get', 'store']);
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
        $pub->address = $request->address;
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
        $ratings = $pub->ratings;
        $rate_avrg = 0;
        $rate_count = 0;
        foreach ($ratings as $rating) {
            $rating->user;
            $rate_avrg += $rating->rate;
            $rate_count += 1;
            $rating->rate = intval($rating->rate);
        }
        $pub->ratings_count = $rate_count;
        $pub->rate_avrg = $rate_avrg / $rate_count;

        $hasDishes = $pub->has_dishes;
        foreach ($hasDishes as $dish) {
            $dish->dish;
        }
        $comments = $pub->comments;
        foreach ($comments as $comment) {
            $comment->user;
        }
        $pub->loadCount('comments');
        return $this->sendRespondSuccess($pub, 'Get successfully!');
    }

    public function store()
    {
        $pubs = Pub::all();
        return $this->sendRespondSuccess($pubs, 'Get Pubs successfully!');
    }

    public function storeMyPub()
    {
        return $this->sendRespondSuccess(auth()->user()->pubs, 'Get Pub successfully!');
    }

    public function update(UpdatePubRequest $request, Pub $pub)
    {
        if ($pub->user_id != auth()->user()->id) return $this->sendForbidden();
        if ($request->description) {
            $pub->description = $request->description;
        }
        if ($request->name) {
            $pub->name = $request->name;
        }
        if ($request->main_email) {
            $pub->main_email = $request->main_email;
        }
        if ($request->phone_number) {
            $pub->phone_number = $request->phone_number;
        }
        if ($request->address) {
            $pub->address = $request->address;
        }
        if ($request->business_time) {
            $pub->business_time = $request->business_time;
        }
        if ($request->video_path) {
            $pub->video_path = $request->video_path;
        }
        if ($request->map_path) {
            $pub->map_path = $request->map_path;
        }
        if ($request->hasFile('image')) {
            $image = $request->image;
            $uploadFolder = 'public/pubs/' . $pub->id . '/home_image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs($uploadFolder, $imageName);
            $image_photo_path = env('APP_URL') . '/storage/' . Str::after($path, 'public/');
            $pub->home_photo_path = $image_photo_path;
        }
        $pub->save();
        return $this->sendRespondSuccess($pub, 'Update Pub successfully!');
    }
}
