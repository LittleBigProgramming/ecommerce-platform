<?php

namespace App\Models\Traits;

use App\Cart\Money;

trait HasPrice
{
    /**
     * @param $value
     * @return Money
     */
    public function getPriceAttribute($value)
    {
        return new Money($value);
    }

    /**
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return $this->price->formatted();
    }
}
