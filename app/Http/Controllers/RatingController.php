<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Pub;
use App\Models\Rating;
use Illuminate\Http\Request;

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
            return $this->sendRespondSuccess($rating, 'Rate successfully!');
        } else return $this->sendRespondError($isRated, 'You had been rated', 500);
    }

    public function get(Pub $pub)
    {
        $ratings = $pub->ratings;
        return $this->sendRespondSuccess($ratings, 'Get Rating successfully!');
    }
}
