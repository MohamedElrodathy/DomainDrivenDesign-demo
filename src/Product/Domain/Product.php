<?php

declare(strict_types=1);

namespace Product\Domain;

use DateTimeImmutable;
use DomainDrivenDesign\AggregateRootInterface;

final class Product implements AggregateRootInterface
{
    /** @var ProductId */
    private $id;
    /** @var string */
    private $description;
    /** @var Seller */
    private $owner;
    /** @var Price[] */
    private $prices = [];

    public function getPriceForGivenDate(DateTimeImmutable $date): ?Price
    {
        foreach ($this->prices as $price) {
            if ($price->isAvailableForDate($date)) {
                return $price;
            }
        }

        return null;
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getOwner(): Seller
    {
        return $this->owner;
    }
}
