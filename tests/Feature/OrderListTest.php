<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class OrderListTest extends TestCase
{
    use RefreshDatabase;
    #[DataProvider('invalidPaginationInputs')]
    public function test_invalid_query_params_for_getting_orders(array $query, string $field, $status): void
    {

        $response = $this->getJson('api/order/get?'.http_build_query($query));

        $response->assertStatus($status);
    }

    public static function invalidPaginationInputs(): array{
        return [
            'page must be an integer' => [['page' => 'abc'], 'page', 422],
            'page must be positive' => [['page' => 0], 'page', 422],
            'per_page must be positive' => [['limit' => 0], 'limit', 422],
            'per_page must not exceed the limit' => [['limit' => 101], 'limit', 404],
        ];
    }

    #[DataProvider('validPaginationInputs')]
    public function test_valid_query_params_for_getting_orders(array $query, string $field, $status): void {
        $response = $this->getJson('api/order/get?'.http_build_query($query));
        dump($query);
        dump('api/order/get?'.http_build_query($query));
        dump($response->status());
        dump($response->json());
        $response->assertStatus($status);
    }

    public static function validPaginationInputs(): array{
        return [
            'page must be an integer' => [['page' => 1], 'page', 404],
            'page must be positive' => [['page' => 2], 'page', 404],
            'per_page must be positive' => [['limit' => 101], 'limit', 404],
            'per_page must not exceed the limit' => [['limit' => 101], 'limit', 404],
        ];
    }
}
