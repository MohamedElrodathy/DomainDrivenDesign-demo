<?php

declare(strict_types=1);

namespace Product\Domain\AddPrice;

use DateTimeImmutable;
use DomainDrivenDesign\Event\EventInterface;
use Money\Money;
use Product\Domain\ProductId;

final class PriceAddedEvent implements EventInterface
{
    /** @var Money */
    private $amount;
    /** @var DateTimeImmutable */
    private $availableFrom;
    /** @var DateTimeImmutable */
    private $availableUntil;
    /** @var ProductId */
    private $productId;

    /**
     * @param ProductId         $productId
     * @param Money             $amount
     * @param DateTimeImmutable $availableFrom
     * @param DateTimeImmutable $availableUntil
     */
    public function __construct(
        ProductId $productId,
        Money $amount,
        DateTimeImmutable $availableFrom,
        DateTimeImmutable $availableUntil
    ) {
        $this->productId = $productId;
        $this->amount = $amount;
        $this->availableFrom = $availableFrom;
        $this->availableUntil = $availableUntil;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getAvailableFrom(): DateTimeImmutable
    {
        return $this->availableFrom;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getAvailableUntil(): DateTimeImmutable
    {
        return $this->availableUntil;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId
    {
        return $this->productId;
    }
}
