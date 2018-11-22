<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EndpointIndexTest extends TestCase
{
    public function testReturnsCollection()
    {
        $categories = factory(Category::class, 20)->create();

        $response = $this->json('GET', 'api/categories');

        $categories->each(function ($category) use ($response) {
            $response->assertJsonFragment([
                'slug' => $category->slug,
            ]);
        });
    }

    public function testReturnsOnlyParents()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            $subcategory = factory(Category::class)->create()
        );

        $this->json('GET', 'api/categories')
            ->assertJsonCount(1, 'data');
    }

    public function testReturnsOrdered()
    {
        $category = factory(Category::class)->create([
            'order' => 2
        ]);

        $anotherCategory = factory(Category::class)->create([
            'order' => 1
        ]);

        $this->json('GET', 'api/categories')
            ->assertSeeInOrder([
                $anotherCategory->slug, $category->slug
            ]);
    }
}
