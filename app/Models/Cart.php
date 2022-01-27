<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    protected $appends = ['total_price'];

    public function ScopeClear(Builder $query)
    {
        return $query->where('user_id', auth()->id())->delete();
    }

    public function ScopeContent(Builder $query)
    {
        return $query->with('product')->where('user_id', auth()->id())->get();
    }

    public function ScopeCountCart(Builder $query)
    {
        return $query->where('user_id', auth()->id())->count();
    }

    public function ScopeTotal(Builder $query)
    {
        return Cart::Content()->sum('total_price');
    }

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->product->price;
    }

    /**
     * Get the user that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
