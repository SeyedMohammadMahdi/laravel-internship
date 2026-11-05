<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;
    #[DataProvider("validDataProvider")]
    public function test_example(array $data, $status): void
    {

        $response = $this->postJson('api/products/create', $data);
        dump($response->json());
        $response->assertStatus($status)->assertJsonStructure([
            "message",
        ]);
    }

    public static function validDataProvider(): array{
        return [
            "valid-basic-fruit" => [
                [
                    "name" => "banana",
                    "price" => 100,
                    "category" => "fruit",
                    "stock" => 100
                ],
                201
            ],
            "valid-basic-electronics" => [
                [
                    "name" => "headphones",
                    "price" => 999.99,
                    "category" => "electronics",
                    "stock" => 50
                ],
                201
            ],

            "valid-name-min-length-3" => [
                [
                    "name" => "abc",
                    "price" => 100,
                    "category" => "fruit",
                    "stock" => 100
                ],
                201
            ],
            "valid-name-max-length-255" => [
                [
                    "name" => str_repeat("a", 255),
                    "price" => 100,
                    "category" => "fruit",
                    "stock" => 100
                ],
                201
            ],

            "valid-price-min-zero" => [
                [
                    "name" => "free-item",
                    "price" => 0,
                    "category" => "fruit",
                    "stock" => 100
                ],
                201
            ],
            "valid-price-max-1000" => [
                [
                    "name" => "expensive-item",
                    "price" => 1000,
                    "category" => "electronics",
                    "stock" => 10
                ],
                201
            ],

            "valid-stock-min-zero" => [
                [
                    "name" => "out-of-stock-item",
                    "price" => 100,
                    "category" => "fruit",
                    "stock" => 0
                ],
                201
            ],
            "valid-high-stock" => [
                [
                    "name" => "bulk-item",
                    "price" => 10,
                    "category" => "wholesale",
                    "stock" => 1000000
                ],
                201
            ],

            "valid-category-min-length-3" => [
                [
                    "name" => "item",
                    "price" => 100,
                    "category" => "abc",
                    "stock" => 100
                ],
                201
            ],
            "valid-category-max-length-100" => [
                [
                    "name" => "item",
                    "price" => 100,
                    "category" => str_repeat("c", 100),
                    "stock" => 100
                ],
                201
            ],

            "valid-all-min-boundaries" => [
                [
                    "name" => "abc",
                    "price" => 0,
                    "category" => "xyz",
                    "stock" => 0
                ],
                201
            ],
            "valid-all-max-boundaries" => [
                [
                    "name" => str_repeat("n", 255),
                    "price" => 1000,
                    "category" => str_repeat("c", 100),
                    "stock" => 999999
                ],
                201
            ],

            "valid-price-decimal" => [
                [
                    "name" => "precision-item",
                    "price" => 99.99,
                    "category" => "electronics",
                    "stock" => 100
                ],
                201
            ],
            "valid-price-high-decimal" => [
                [
                    "name" => "precise-price",
                    "price" => 123.456,
                    "category" => "electronics",
                    "stock" => 100
                ],
                201
            ],
        ];
    }


}
