<?php

namespace App\Models;

use App\Models\Traits\HasPrice;
use App\Models\Traits\IsScopable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use IsScopable, HasPrice;
    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    public function stockCount()
    {
        return $this->variations->sum(function ($variation) {
            return $variation->stockCount();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }
}
