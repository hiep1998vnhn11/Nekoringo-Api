<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\UpdateDishRequest;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DishRequest;

class DishController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::with('category')->orderBy('created_at', 'desc')->get();
        return $this->sendRespondSuccess($dishes, 'Get dishes successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $dish->category;
        return $this->sendRespondSuccess($dish, 'Create Pub successfully!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDishRequest $request, Dish $dish)
    {
        if ($request->category) {
            $category = Category::findOrFail($request->category);
            $dish->category_id = $category->id;
        }
        if ($request->name) $dish->name = $request->name;
        if ($request->description) $dish->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $uploadFolder = 'dishes/image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
            Storage::disk('s3')->setVisibility($image_photo_path, 'public');
            $path = Storage::disk('s3')->url($image_photo_path);
            $dish->photo_path = $path;
        }
        $dish->save();
        return $this->sendRespondSuccess($dish, 'Update Dish successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return $this->sendRespondSuccess($dish, 'Delete dish successfully!');
    }
}
