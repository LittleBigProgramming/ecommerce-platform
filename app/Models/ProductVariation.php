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
}
