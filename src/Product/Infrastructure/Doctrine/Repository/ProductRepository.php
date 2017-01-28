<?php

declare(strict_types=1);

namespace Product\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Product\Domain\Product;
use Product\Domain\ProductId;
use Product\Domain\Repository\ProductRepositoryInterface;

final class ProductRepository extends EntityRepository implements ProductRepositoryInterface
{
    public function load(ProductId $productId): ?Product
    {
        $object = $this->find($productId);
        if (!$object instanceof Product) {
            return null;
        }

        return $object;
    }

    public function save(Product $product): void
    {
        $this->_em->persist($product);
        $this->_em->flush($product);
    }
}
