<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductObserver
{

    public function creating(Product $product)
    {
        if (request()->hasFile('image')) {
            $name = request()->file('image')->storeAs('images/products', request()->file('image')->hashName(), 'public');
            $product->image = $name;
        }
    }


    public function updating(Product $product)
    {
        if (request()->hasFile('image')) {
            if (File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $name = request()->file('image')->storeAs('images/products', request()->file('image')->hashName(), 'public');
            $product->image = $name;
        }
    }

    public function deleted(Product $product)
    {
        if (File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
    }

}
