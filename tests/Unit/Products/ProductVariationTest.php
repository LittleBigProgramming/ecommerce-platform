<?php

namespace Tests\Unit\Products;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariationTest extends TestCase
{

    public function testHasOneVariationType()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(ProductVariationType::class, $variation->type);
    }

    public function testBelongsToProduct()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Product::class, $variation->product);
    }
}
