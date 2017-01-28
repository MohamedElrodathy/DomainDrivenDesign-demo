<?php

declare(strict_types=1);

namespace Product\Domain\Repository;

use Product\Domain\Product;
use Product\Domain\ProductId;

interface ProductRepositoryInterface
{
    public function load(ProductId $productId): ?Product;

    public function save(Product $product): void;
}
