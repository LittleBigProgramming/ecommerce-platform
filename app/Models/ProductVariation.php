<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasPrice;

    /**
     * @param $value
     * @return Money
     */
    public function getPriceAttribute($value)
    {
        return $value ? new Money($value) : $this->product->price;
    }

    /**
     * @return bool
     */
    public function priceVaries()
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

    /**
     * @return bool
     */
    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    /**
     * @return mixed
     */
    public function stockCount()
    {
        return $this->stock->sum('pivot.stock');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'variation_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Need to get Pivot information of ProductVariation instance from the related view table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stock()
    {
        return $this->belongsToMany(
            ProductVariation::class, 'product_variation_stock_view'
        )->withPivot([
            'stock',
            'in_stock'
        ]);
    }
}
