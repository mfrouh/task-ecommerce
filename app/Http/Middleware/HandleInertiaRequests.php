<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Inertia\Middleware;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? $request->user()->only('id', 'email', 'name') : null,
            ],
            'cartCount' => $request->user() ? Cart::content()->count() : 0,
            'categories' => CategoryResource::collection(Category::has('products')->active()->get()),
        ]);
    }
}
