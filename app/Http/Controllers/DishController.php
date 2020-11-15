<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Requests\AddDishRequest;
use App\Http\Requests\DishRequest;
use App\Models\Pub;
use App\Models\Pub_has_Dish;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DishController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['get', 'store']);
    }
    public function store(Request $request)
    {
        $dishes = [];
        $param = $request->all();
        $category = Arr::get($param, 'category', null);
        $searchKey = Arr::get($param, 'search_key', null);
        if ($category) {
            $cate = Category::findOrFail($category);
            $dishes = $cate->dishes;
        } else {
            $dishes = Dish::orderBy('id');
        }
        if ($searchKey) {
            $dishes = $dishes->where('name', 'like', '%' . $searchKey . '%');
        }
        $dishes = $dishes->get();
        return $this->sendRespondSuccess($dishes, 'Store dishes successfully!');
    }

    public function add(Dish $dish, AddDishRequest $request)
    {
        $pub = Pub::findOrFail($request->pub_id);
        if (auth()->user()->id != $pub->user_id) return $this->sendForbidden();
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

    public function create(DishRequest $request)
    {
        $category = Category::findOrFail($request->category);
        $dish = new Dish();
        $dish->name = $request->name;
        $dish->description = $request->description;
        $dish->category_id = $category->id;
        $image_photo_path = null;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $uploadFolder = 'dishes/image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
            Storage::disk('s3')->setVisibility($image_photo_path, 'public');
            $path = Storage::disk('s3')->url($image_photo_path);
        }
        $dish->photo_path = $path;
        $dish->save();
        return $this->sendRespondSuccess($dish, 'Create Pub successfully!');
    }
}
