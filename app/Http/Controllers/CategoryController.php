<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
}
