<?php

declare(strict_types=1);

namespace Product\Domain\AddPrice;

use DateTimeImmutable;
use DomainDrivenDesign\Command\CommandInterface;
use Money\Money;
use Product\Domain\Exception\WrongDateRangeException;
use Product\Domain\ProductId;
use Product\Domain\SellerId;

final class AddPriceCommand implements CommandInterface
{
    /** @var ProductId */
    private $productId;
    /** @var SellerId */
    private $sellerId;
    /** @var DateTimeImmutable */
    private $availableFrom;
    /** @var DateTimeImmutable */
    private $availableUntil;
    /** @var Money */
    private $amount;

    public function __construct(
        ProductId $productId,
        SellerId $sellerId,
        DateTimeImmutable $availableFrom,
        DateTimeImmutable $availableUntil,
        Money $amount
    ) {
        if ($availableFrom > $availableUntil) {
            throw new WrongDateRangeException();
        }
        $this->productId = $productId;
        $this->sellerId = $sellerId;
        $this->availableFrom = $availableFrom;
        $this->availableUntil = $availableUntil;
        $this->amount = $amount;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getSellerId(): SellerId
    {
        return $this->sellerId;
    }

    public function getAvailableFrom(): DateTimeImmutable
    {
        return $this->availableFrom;
    }

    public function getAvailableUntil(): DateTimeImmutable
    {
        return $this->availableUntil;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}
