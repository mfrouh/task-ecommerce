<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Category $category, Request $request)
    {
        $products = ProductResource::collection(Product::where('category_id', $category->id)->active()->paginate(16));
        return Inertia::render('Frontend/Category', ['category' => CategoryResource::make($category), 'products' => $products]);
    }
}
