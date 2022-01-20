<?php

namespace App\Models;

use App\Models\Category;
use App\Traits\SlugTrait;
use App\Traits\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SlugTrait;
    use ActiveScope;

    protected $fillable = ['name', 'slug', 'status', 'price', 'image', 'description', 'quantity', 'category_id'];


    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
