<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $products = ProductResource::collection(Product::whereHas('category', function ($query) {
            $query->active();
        })->filter()->active()->get());
        $categories = CategoryResource::collection(Category::has('products')->active()->get());
        return Inertia::render('Frontend/Home', ['products' => $products, 'categories' => $categories]);
    }
}
