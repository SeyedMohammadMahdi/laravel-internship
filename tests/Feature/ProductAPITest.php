<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProductAPITest extends TestCase
{
//    use RefreshDatabase;
    use DatabaseMigrations;
    #[DataProvider("getProductsDataProvider")]
    public function testGetApi(array $data, int $count, array $query, $status):void{
        $i = 0;
        foreach($data as $product){
            if ($i === $count){
                break;
            }
            $this->postJson("/api/products/create", $product);
            $i++;
        }

        $response = $this->getJson("/api/products/get?".http_build_query($query));
        $response->assertStatus($status);
    }
    public static function getProductsDataProvider():array{
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
        ]
        ;

        return [
            // [description, CountOfProductsToCreate, [page, perPage], expectedStatus]

            "first-page-exact-fit"        => [$data, 10, ["page" => 1, "perPage" => 10], 200],
            "without-query-parameter"        => [$data, 10, ["page" => null, "perPage" => null], 200],
            "second-page-empty"           => [$data, 10, ["page" => 2, "perPage" => 10], 200],

            "first-page-partial"          => [$data, 5,  ["page" => 1, "perPage" => 10], 200],
            "first-page-multiple-pages"   => [$data, 15, ["page" => 1, "perPage" => 10], 200],
            "second-page-partial"         => [$data, 15, ["page" => 2, "perPage" => 10], 200],
            "third-page-empty"            => [$data, 15, ["page" => 3, "perPage" => 10], 200],

            "perPage-5-first-page"        => [$data, 12, ["page" => 1, "perPage" => 5],  200],
            "perPage-5-second-page"       => [$data, 12, ["page" => 2, "perPage" => 5],  200],
            "perPage-5-third-page"        => [$data, 12, ["page" => 3, "perPage" => 5],  200],
            "perPage-20-all-in-one"       => [$data, 15, ["page" => 1, "perPage" => 20], 200],
            "perPage-1-each-page"         => [$data, 3,  ["page" => 2, "perPage" => 1],  200],

            "page-0-treated-as-1"         => [$data, 5,  ["page" => 0, "perPage" => 10], 422],
            "negative-page-treated-as-1"  => [$data, 5,  ["page" => -1, "perPage" => 10], 422],
            "perPage-0-returns-all"       => [$data, 5,  ["page" => 1, "perPage" => 0],  422],
            "large-page-empty"            => [$data, 5,  ["page" => 999, "perPage" => 10], 200],

            "empty-db-first-page"         => [$data, 0,  ["page" => 1, "perPage" => 10], 200],
            "empty-db-any-page"           => [$data, 0,  ["page" => 5, "perPage" => 10], 200],

            "large-dataset-page-1"        => [$data, 100, ["page" => 1, "perPage" => 15], 200],
            "large-dataset-last-page"     => [$data, 100, ["page" => 7, "perPage" => 15], 200],
        ];
    }

    #[DataProvider("getOneProductDataProvider")]
    public function testGetOneProduct(array $data, int $index):void {
        $response = $this->postJson("/api/products/create", $data[$index]);
        $id = $response->json()['id'];

        $getResponse = $this->getJson("/api/products/get/$id");
        $getResponse->assertStatus(200)->assertJsonStructure([
            "data" => []
        ])->assertJsonPath("data.id", $id);
    }

    public static function getOneProductDataProvider(): array {
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
            "product-1" => [$data, 0],
            "product-2" => [$data, 1],
            "product-3" => [$data, 2],
            "product-4" => [$data, 3],
            "product-5" => [$data, 4],
            "product-6" => [$data, 5],
            "product-7" => [$data, 6],
            "product-8" => [$data, 7],
            "product-9" => [$data, 8],
            "product-10" => [$data, 9],
            "product-11" => [$data, 10],
        ]
            ;

    }
}
