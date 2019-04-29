<?php

namespace Tests\Unit\Products;

use App\Cart\Money;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    public function testUsesSlugForRoute()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }

    public function testHasManyCategories()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $product->categories->first());
    }

    public function testHasManyVariations()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());
    }

    public function testReturnsMoneyInstanceForPrice()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Money::class, $product->price);
    }

    public function testReturnsFormattedPrice()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $this->assertEquals($product->formattedPrice, '£10.00');
    }

    public function testCanCheckIfInStock()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->create()
        );

        $variation->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertTrue($product->inStock());
    }

    public function testCanGetTheStockCount()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->create()
        );

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($product->stockCount(), $quantity);
    }
}
