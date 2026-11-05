<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProductGetTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_products(): void
    {
        $products = [
            ['name' => 'Banana', 'price' => 100, 'category' => 'fruit', 'stock' => 50],
            ['name' => 'Headphones', 'price' => 999.99, 'category' => 'electronics', 'stock' => 25],
            ['name' => 'Apple', 'price' => 50, 'category' => 'fruit', 'stock' => 100],
        ];

        foreach ($products as $product) {
            $this->postJson('/api/products/create', $product)->assertStatus(201);
        }

        $response = $this->getJson('/api/products/get');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_get_single_product_by_id(): void
    {
        $createResponse = $this->postJson('/api/products/create', [
            'name' => 'Single Product',
            'price' => 150,
            'category' => 'test',
            'stock' => 10,
        ])->assertStatus(201);

        $productId = $createResponse->json('id');

        $response = $this->getJson("/api/products/get/{$productId}");
        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Single Product')
                 ->assertJsonPath('data.price', 150);
    }

    public function test_get_nonexistent_product_returns_404(): void
    {
        $response = $this->getJson('/api/products/get/99999');

        $response->assertStatus(404);
    }

    #[DataProvider("paginationInputs")]
    public function test_pagination(array $productData, int $productsToCreate, array $pagination, int $expectedStatus, int $expectedCount): void {
        for ($i = 1; $i <= $productsToCreate; $i++) {
            $this->postJson('/api/products/create', [
                'name' => "Product {$i}",
                'price' => 10 * $i,
                'category' => 'pagination',
                'stock' => 5,
            ])->assertStatus(201);
        }

        $response = $this->getJson('/api/products/get?'.http_build_query($pagination));

        $response->assertStatus($expectedStatus);

        if ($expectedStatus === 200) {
            $response->assertJsonCount($expectedCount, 'data');
        }
    }

    public static function paginationInputs(): array
    {
        $data = [
            [
                "name" => "banana",
                "price" => 100,
                "category" => "fruit",
                "stock" => 100
            ],
            [
                "name" => "headphones",
                "price" => 999.99,
                "category" => "electronics",
                "stock" => 50
            ],
            [
                "name" => "abc",
                "price" => 100,
                "category" => "fruit",
                "stock" => 100
            ],
            [
                "name" => str_repeat("a", 255),
                "price" => 100,
                "category" => "fruit",
                "stock" => 100
            ],
            [
                "name" => "free-item",
                "price" => 0,
                "category" => "fruit",
                "stock" => 100
            ],
            [
                "name" => "expensive-item",
                "price" => 1000,
                "category" => "electronics",
                "stock" => 10
            ],
            [
                "name" => "out-of-stock-item",
                "price" => 100,
                "category" => "fruit",
                "stock" => 0
            ],
            [
                "name" => "bulk-item",
                "price" => 10,
                "category" => "wholesale",
                "stock" => 1000000
            ],
            [
                "name" => "item",
                "price" => 100,
                "category" => "abc",
                "stock" => 100
            ],
            [
                "name" => "item",
                "price" => 100,
                "category" => str_repeat("c", 100),
                "stock" => 100
            ],
            [
                "name" => "abc",
                "price" => 0,
                "category" => "xyz",
                "stock" => 0
            ],
            [
                "name" => str_repeat("n", 255),
                "price" => 1000,
                "category" => str_repeat("c", 100),
                "stock" => 999999
            ],
            [
                "name" => "precision-item",
                "price" => 99.99,
                "category" => "electronics",
                "stock" => 100
            ],
            [
                "name" => "precise-price",
                "price" => 123.456,
                "category" => "electronics",
                "stock" => 100
            ],
        ];
        return [
            "first-page-exact-fit"        => [$data, 10, ["page" => 1, "perPage" => 10], 200, 10],
            "second-page-empty"           => [$data, 10, ["page" => 2, "perPage" => 10], 404, 0],
            "first-page-partial"          => [$data, 5,  ["page" => 1, "perPage" => 10], 200, 5],
            "first-page-multiple-pages"   => [$data, 15, ["page" => 1, "perPage" => 10], 200, 10],
            "second-page-partial"         => [$data, 15, ["page" => 2, "perPage" => 10], 200, 5],
            "third-page-empty"            => [$data, 15, ["page" => 3, "perPage" => 10], 404, 0],
            "perPage-5-first-page"        => [$data, 12, ["page" => 1, "perPage" => 5],  200, 5],
            "perPage-5-second-page"       => [$data, 12, ["page" => 2, "perPage" => 5],  200, 5],
            "perPage-5-third-page"        => [$data, 12, ["page" => 3, "perPage" => 5],  200, 2],
            "perPage-20-all-in-one"       => [$data, 15, ["page" => 1, "perPage" => 20], 200, 15],
            "perPage-1-each-page"         => [$data, 3,  ["page" => 2, "perPage" => 1],  200, 1],
            "page-0-treated-as-1"         => [$data, 5,  ["page" => 0, "perPage" => 10], 422, 5],
            "negative-page-treated-as-1"  => [$data, 5,  ["page" => -1, "perPage" => 10], 422, 5],
            "perPage-0-returns-all"       => [$data, 5,  ["page" => 1, "perPage" => 0],  422, 5],
            "large-page-empty"            => [$data, 5,  ["page" => 999, "perPage" => 10], 404, 0],
            "empty-db-first-page"         => [$data, 0,  ["page" => 1, "perPage" => 10], 404, 0],
            "empty-db-any-page"           => [$data, 0,  ["page" => 5, "perPage" => 10], 404, 0],
            "large-dataset-page-1"        => [$data, 100, ["page" => 1, "perPage" => 15], 200, 15],
            "large-dataset-last-page"     => [$data, 100, ["page" => 7, "perPage" => 15], 200, 10],
        ];
    }
}
