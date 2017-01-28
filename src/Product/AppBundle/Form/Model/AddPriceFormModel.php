<?php

declare(strict_types=1);

namespace Product\AppBundle\Form\Model;

use DateTime;
use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use Product\Domain\AddPrice\AddPriceCommand;
use Product\Domain\ProductId;
use Product\Domain\SellerId;

final class AddPriceFormModel
{
    /** @var string */
    private $productId;
    /** @var string */
    private $sellerId;
    /** @var DateTime */
    private $availableFrom;
    /** @var DateTime */
    private $availableUntil;
    /** @var string */
    private $amount;

    public function toCommand(): AddPriceCommand
    {
        return new AddPriceCommand(
            ProductId::fromString($this->productId),
            SellerId::fromString($this->sellerId),
            DateTimeImmutable::createFromMutable($this->availableFrom),
            DateTimeImmutable::createFromMutable($this->availableUntil),
            new Money($this->amount, new Currency('EUR'))
        );
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    public function setSellerId(string $sellerId): void
    {
        $this->sellerId = $sellerId;
    }

    public function getAvailableFrom(): DateTime
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(DateTime $availableFrom): void
    {
        $this->availableFrom = $availableFrom;
    }

    public function getAvailableUntil(): DateTime
    {
        return $this->availableUntil;
    }

    public function setAvailableUntil(DateTime $availableUntil): void
    {
        $this->availableUntil = $availableUntil;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function setAmount(Money $amount): void
    {
        $this->amount = $amount;
    }
}
