<?php

declare(strict_types=1);

namespace Product\Domain;

use DateTimeImmutable;
use DomainDrivenDesign\AggregateRootInterface;
use Product\Domain\AddPrice\AddPriceCommand;
use Product\Domain\Exception\OnlyOwnerMayAddPriceException;
use Product\Domain\Exception\PriceAvailabilityException;

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

    public function addPrice(AddPriceCommand $command): void
    {
        if ($command->getSellerId() !== $this->owner->getId()) {
            throw new OnlyOwnerMayAddPriceException();
        }

        $time = sprintf('+%d days', Price::VALIDATION_PERIOD);
        $minimumStartDate = new DateTimeImmutable($time);
        if ($minimumStartDate > $command->getAvailableFrom()) {
            throw PriceAvailabilityException::tooSoon(Price::VALIDATION_PERIOD);
        }

        foreach ($this->prices as $price) {
            $hasCommonDates = $price->hasCommonDatesWithRange(
                $command->getAvailableFrom(),
                $command->getAvailableUntil()
            );
            if ($hasCommonDates) {
                throw PriceAvailabilityException::priceAlreadyExists($price);
            }
        }

        $this->prices[] = new Price($command->getAmount(), $command->getAvailableFrom(), $command->getAvailableUntil());
    }

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
