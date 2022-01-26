<?php

namespace App\Models;

use App\Models\Category;
use App\Traits\ActiveScope;
use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    use SlugTrait;
    use ActiveScope;

    protected $fillable = ['name', 'slug', 'status', 'price', 'image', 'description', 'quantity', 'category_id'];

    protected $appends = ['quantity_in_cart'];

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ScopeMaxPriceThan(Builder $query, $price)
    {
        $query->where('price', '<=', $price);
    }

    public function ScopeMinPriceThan(Builder $query, $price)
    {
        $query->where('price', '>=', $price);
    }

    public function ScopeFilter(Builder $query)
    {
        $query
            ->when(request('categories'), fn(Builder $query) => $query->whereIn('category_id', request('categories')))
            ->when(request('min_price'), fn(Builder $query) => $query->minPriceThan(request('min_price')))
            ->when(request('max_price'), fn(Builder $query) => $query->maxPriceThan(request('max_price')));

    }

    public function getQuantityInCartAttribute()
    {
        return Cart::where('user_id', auth()->id())->where('product_id', $this->id)->first()?->quantity ?? 1;
    }
}
