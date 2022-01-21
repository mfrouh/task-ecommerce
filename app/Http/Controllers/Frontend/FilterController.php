<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FilterController extends Controller
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
        })->Filter()->active()->get());
        $categories = CategoryResource::collection(Category::active()->get());
        return response()->json(['products' => $products, 'categories' => $categories], 200);
    }
}
