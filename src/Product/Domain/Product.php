<?php

declare(strict_types=1);

namespace Product\Domain;

use DateTimeImmutable;
use DomainDrivenDesign\AggregateRootInterface;
use DomainDrivenDesign\Event\EventInterface;
use Product\Domain\AddPrice\AddPriceCommand;
use Product\Domain\AddPrice\PriceAddedEvent;
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
    /** @var EventInterface[] */
    private $events = [];

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

        $event = new PriceAddedEvent(
            $this->id,
            $command->getAmount(),
            $command->getAvailableFrom(),
            $command->getAvailableUntil()
        );
        $this->events[] = $event;

        $this->applyPriceAdded($event);
    }

    /** @return EventInterface[] */
    public function pullDomainEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
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

    private function applyPriceAdded(PriceAddedEvent $event): void
    {
        $this->prices[] = new Price(
            $event->getAmount(),
            $event->getAvailableFrom(),
            $event->getAvailableUntil()
        );
    }
}
