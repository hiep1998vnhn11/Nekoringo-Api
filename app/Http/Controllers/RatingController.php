<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Pub;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            $path = null;
            if ($request->hasFile('image')) {
                $image = $request->image;
                $uploadFolder = 'pubs/' . $pub->id . '/rating_image';
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
                Storage::disk('s3')->setVisibility($image_photo_path, 'public');
                $path = Storage::disk('s3')->url($image_photo_path);
            }
            if ($path) {
                $rating->image_path = $path;
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

    public function delete(Rating $rating)
    {
        if ($rating->user_id != auth()->user()->id) return $this->sendForbidden();
        $rating->delete();
        return $this->sendRespondSuccess($rating, 'Delete successfully!');
    }
}
