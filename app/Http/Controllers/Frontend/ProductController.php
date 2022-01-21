<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product, Request $request)
    {
        return Inertia::render('Product', ['product' => ProductResource::make($product)]);
    }
}
