<?php

declare(strict_types=1);

namespace Product\Infrastructure\InMemory\Repository;

use Product\Domain\Product;
use Product\Domain\ProductId;
use Product\Domain\Repository\ProductRepositoryInterface;

final class ProductRepository implements ProductRepositoryInterface
{
    /** @var Product[] */
    private $products = [];

    public function load(ProductId $productId): ?Product
    {
        $keyInStore = $this->guessKeyFromProductId($productId);
        if (!isset($this->products[$keyInStore])) {
            return null;
        }

        return $this->products[$keyInStore];
    }

    public function save(Product $product): void
    {
        $keyInStore = $this->guessKeyFromProductId($product->getId());
        $this->products[$keyInStore] = $product;
    }

    private function guessKeyFromProductId(ProductId $productId): string
    {
        return $productId->getValue()->toString();
    }
}
