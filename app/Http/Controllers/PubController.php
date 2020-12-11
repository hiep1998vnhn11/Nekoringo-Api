<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeDishRequest;
use App\Http\Requests\PubRequest;
use App\Http\Requests\UpdatePubRequest;
use App\Models\Pub;
use App\Models\Pub_has_Dish;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Models\Dish;

class PubController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['get', 'store', 'storeDish']);
        $this->middleware('role:publican')->except(['get', 'store', 'storeDish']);
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
            $uploadFolder = 'pubs/' . $pub->id . '/home_image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
            Storage::disk('s3')->setVisibility($image_photo_path, 'public');
            $path = Storage::disk('s3')->url($image_photo_path);
        }
        if ($path) {
            $pub->home_photo_path = $path;
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
        if ($rate_count) {
            $pub->rate_avrg = $rate_avrg / $rate_count;
        } else {
            $pub->rate_avrg = 0;
        }
        $comments = $pub->comments;
        foreach ($comments as $comment) {
            $comment->user;
        }
        $pub->loadCount('comments');

        if (auth()->user() && auth()->user()->hasRole('viewer')) {
            $order = auth()->user()->orders()->where('pub_id', $pub->id)
                ->where('status', 'accepted')
                ->first();
            if ($order) $pub->isOrder = true;
            else $pub->isOrder = false;
        }
        return $this->sendRespondSuccess($pub, 'Get successfully!');
    }

    public function store()
    {
        $pubs = Pub::orderBy('created_at', 'desc')->paginate(6);

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
            $uploadFolder = 'pubs/' . $pub->id . '/home_image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
            Storage::disk('s3')->setVisibility($image_photo_path, 'public');
            $path = Storage::disk('s3')->url($image_photo_path);
            $pub->home_photo_path = $path;
        }
        $pub->save();
        return $this->sendRespondSuccess($pub, 'Update Pub successfully!');
    }

    public function storeDish(Pub $pub, Request $request)
    {
        $has_dishes = null;
        if ($request->type == 'all') $has_dishes = $pub->has_dishes;
        else $has_dishes = $pub->has_dishes()->orderBy('created_at', 'desc')->paginate(8);
        foreach ($has_dishes as $dish) {
            $dish->dish;
        }
        return $this->sendRespondSuccess($has_dishes, 'Get dishes successfully!');
    }

    public function changeDish(Pub $pub, ChangeDishRequest $request)
    {
        if ($pub->user_id !== auth()->user()->id) return $this->sendForbidden();
        $has_dishes_eloquent = $pub->has_dishes();
        $has_dishes = $has_dishes_eloquent->get();
        $dishArray = [];
        foreach ($has_dishes as $dish) array_push($dishArray, $dish->dish_id);
        $dish_delete = array_diff($dishArray, $request->dishes);
        $dish_add = array_diff($request->dishes, $dishArray);

        //Delete dish
        foreach ($dish_delete as $dish_id) {
            $pub_has_dish = $has_dishes_eloquent->where('dish_id', $dish_id);
            $pub_has_dish->delete();
        }

        //create dish
        foreach ($dish_add as $dish_id) {
            $dish = Dish::findOrFail($dish_id);
            $pub_has_dish = new Pub_has_Dish();
            $pub_has_dish->pub_id = $pub->id;
            $pub_has_dish->dish_id = $dish_id;
            $pub_has_dish->save();
        }
        $param = $pub->has_dishes;
        foreach ($param as $has_dish) $has_dish->dish;
        return $this->sendRespondSuccess($param, 'Change dishes success!');
    }

    public function addDish(Pub $pub, Dish $dish)
    {
        if ($pub->user_id != auth()->user()->id) return $this->sendForbidden();
        $dishes = $pub->has_dishes;
        $have_dish = false;
        foreach ($dishes as $has_dish) {
            if ($has_dish->dish_id == $dish->id) $have_dish = true;
        }
        if ($have_dish) return $this->sendRespondError($dish, 'Pub had this dish yet!', 500);
        $pub_has_dish = new Pub_has_Dish();
        $pub_has_dish->pub_id = $pub->id;
        $pub_has_dish->dish_id = $dish->id;
        $pub_has_dish->save();
        return $this->sendRespondSuccess($dish, 'Add dish to pub successfully!');
    }

    public function deleteDish(Pub $pub, Pub_has_Dish $dish)
    {
        if ($pub->user_id != auth()->user()->id) return $this->sendForbidden();
        if ($dish->pub_id != $pub->id) return $this->sendForbidden();
        $dish->delete();
        return $this->sendRespondSuccess($dish, 'Delete dish Successfully!');
    }
}
