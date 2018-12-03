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
