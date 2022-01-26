<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{

    public function created(Product $product)
    {
        if (request()->hasFile('image')) {
            $name = request()->file('image')->storeAs('images/products', request()->file('image')->hashName(), 'public');
            $product->update(['image' => $name]);
        }
    }

    public function updating(Product $product)
    {
        if (request()->hasFile('image')) {
            $image = DB::table('products')->where('id', $product->id)->first()->image;
            $product->image = $image;
        }
    }

    public function updated(Product $product)
    {
        if (request()->hasFile('image')) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $name = request()->file('image')->storeAs('images/products', request()->file('image')->hashName(), 'public');
            $product->updateQuietly(['image' => $name]);
        }
    }

    public function deleted(Product $product)
    {
        if (Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
    }

}
