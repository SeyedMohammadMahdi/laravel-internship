<?php

namespace App\DTOs\Product;

use Illuminate\Http\UploadedFile;

readonly class ProductImageUploadDTO
{
    public function __construct(
        public int $productId,
        public UploadedFile $file,
        public ?string $path = null,
    ) {}
}
