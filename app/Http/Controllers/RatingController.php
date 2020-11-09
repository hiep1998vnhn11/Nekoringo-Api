<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Pub;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RatingController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function create(RatingRequest $request, Pub $pub)
    {
        $ratings = $pub->ratings;
        $isRated = null;
        foreach ($ratings as $rating) {
            if ($rating->user_id == auth()->user()->id) $isRated = $rating;
        }
        if (!$isRated) {
            $rating = new Rating();
            $rating->user_id = auth()->user()->id;
            $rating->pub_id = $pub->id;
            $rating->rate = $request->rate;
            $rating->content = $request->content;
            $rating->save();
            if ($request->hasFile('image')) {
                $image = $request->image;
                $uploadFolder = 'public/pubs/' . $pub->id . '/rating_image';
                $imageName = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs($uploadFolder, $imageName);
                $image_photo_path = env('APP_URL') . '/storage/' . Str::after($path, 'public/');
            }
            if ($image_photo_path) {
                $rating->photo_path = $image_photo_path;
                $rating->save();
            }
            return $this->sendRespondSuccess($rating, 'Rate successfully!');
        } else return $this->sendRespondError($isRated, 'You had been rated', 500);
    }

    public function get(Pub $pub)
    {
        $ratings = $pub->ratings;
        return $this->sendRespondSuccess($ratings, 'Get Rating successfully!');
    }
}
