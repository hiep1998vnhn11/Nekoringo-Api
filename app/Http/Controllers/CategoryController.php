<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends AppBaseController
{
    public function store()
    {
        $categories = Category::all();
        return $this->sendRespondSuccess($categories, 'Get Category successfully!');
    }

    public function get(Category $category)
    {
        $dishes = $category->dishes;
        return $this->sendRespondSuccess($dishes, 'Get Dishes of category' . $category->name . 'Successfully!');
    }

    public function create(CategoryRequest $request)
    {
        if (!$request->image_url && !$request->hasFile('image')) {
            return $this->sendRespondError($request, 'Category not have any image address!', 500);
        }
        $category = new Category();
        $category->name = $request->name;
        if ($request->image_url) $category->image_url = $request->src;
        else {
            $image = $request->image;
            $uploadFolder = 'categories/image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
            Storage::disk('s3')->setVisibility($image_photo_path, 'public');
            $path = Storage::disk('s3')->url($image_photo_path);
            $category->src = $path;
        }
        $category->save();
        return $this->sendRespondSuccess($category, 'Create category successfully!');
    }

    public function delete(Category $category)
    {
        $category->delete();
        return $this->sendRespondSuccess($category, 'Delete category ' . $category->name . ' Successfully!');
    }
}
