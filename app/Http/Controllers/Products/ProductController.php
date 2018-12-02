<?php

namespace App\Http\Controllers\Products;

use App\Http\Resources\ProductIndex;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Scoping\Scopes\CategoryScope;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = Product::withScopes($this->scopes())->paginate(10);

        return ProductIndex::collection($products);
    }

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource(
            $product
        );
    }

    protected function scopes()
    {
        return [
            'category' => new CategoryScope()
        ];
    }
}
