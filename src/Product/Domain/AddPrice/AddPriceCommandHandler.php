<?php

declare(strict_types=1);

namespace Product\Domain\AddPrice;

use DomainDrivenDesign\Command\CommandHandlerInterface;
use Product\Domain\Exception\ProductNotFoundException;
use Product\Domain\Repository\ProductRepositoryInterface;

final class AddPriceCommandHandler implements CommandHandlerInterface
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(AddPriceCommand $command): void
    {
        $product = $this->productRepository->load($command->getProductId());
        if (null === $product) {
            throw new ProductNotFoundException();
        }

        $product->addPrice($command);

        $this->productRepository->save($product);
    }
}
