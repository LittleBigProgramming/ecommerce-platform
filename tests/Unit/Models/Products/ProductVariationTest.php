<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Stock;
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

    public function testReturnsMoneyInstanceForPrice()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Money::class, $variation->price);
    }

    public function testReturnsFormattedPrice()
    {
        $variation = factory(ProductVariation::class)->create([
            'price' => 1000
        ]);

        $this->assertEquals($variation->formattedPrice, '£10.00');
    }

    public function testReturnsPriceIfNull()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $variation = factory(ProductVariation::class)->create([
            'price' => null,
            'product_id' => $product->id
        ]);

        $this->assertEquals($product->price->amount(), $variation->price->amount());
    }

    public function testCheckPriceDifferenceToVariation()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $variation = factory(ProductVariation::class)->create([
            'price' => 2000,
            'product_id' => $product->id
        ]);

        $this->assertTrue($variation->priceVaries());
    }

    public function testHasManyStocks()
    {
        $product = factory(ProductVariation::class)->create();

        $product->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertInstanceOf(Stock::class, $product->stocks->first());
    }

    public function testHasStockInformation()
    {
        $product = factory(ProductVariation::class)->create();

        $product->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertInstanceOf(ProductVariation::class, $product->stock->first());
    }

    public function testHasStockCountPivotWithinStockInformation()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($variation->stock->first()->pivot->stock, $quantity);
    }

    public function testHasStockInStockWithinStockInformation()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertTrue((bool) $variation->stock->first()->pivot->in_stock);
    }

    public function testCanCheckIfInStock()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertTrue($variation->inStock());
    }

    public function testCanGetStockCount()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => 5
            ])
        );

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => 5
            ])
        );

        $this->assertEquals($variation->stockCount(), 10);
    }
}
