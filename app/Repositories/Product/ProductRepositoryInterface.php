<?php
namespace App\Repositories\Product;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

interface ProductRepositoryInterface
{
    public function all(int $page = 1, int $perPage = 10);
    public function find(int $id);
    public function create(string $name, string $category, float $price, int $stock);
    public function update(int $id, ?string $name=null, ?string $category=null, ?float $price=null, ?int $stock = null);
    public function delete(int $id);
    public function filter(?string $name=null, ?string $category = null, ?bool $is_available = null, ?float $min_price = null, ?float $max_price = null);
}
