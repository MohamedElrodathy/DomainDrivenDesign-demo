<?php

declare(strict_types=1);

namespace Product\Domain;

use DateTimeImmutable;
use DomainDrivenDesign\ValueObjectInterface;
use Money\Money;

final class Price implements ValueObjectInterface
{
    const VALIDATION_PERIOD = 10;

    /** @var DateTimeImmutable */
    private $availableFrom;
    /** @var DateTimeImmutable */
    private $availableUntil;
    /** @var Money */
    private $value;

    public function __construct(Money $value, DateTimeImmutable $availableFrom, DateTimeImmutable $availableUntil)
    {
        $this->availableFrom = $availableFrom;
        $this->availableUntil = $availableUntil;
        $this->value = $value;
    }

    public function hasCommonDatesWithRange(DateTimeImmutable $from, DateTimeImmutable $until): bool
    {
        return $until >= $this->availableFrom && $this->availableUntil >= $from;
    }

    public function isEqualTo($object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $object->availableFrom === $this->availableFrom
            && $object->availableUntil === $this->availableUntil
            && $this->value->equals($object->value);
    }

    public function isAvailableForDate(DateTimeImmutable $date): bool
    {
        return $this->availableFrom <= $date && $date <= $this->availableUntil;
    }

    public function getAvailableFrom(): DateTimeImmutable
    {
        return $this->availableFrom;
    }

    public function getAvailableUntil(): DateTimeImmutable
    {
        return $this->availableUntil;
    }

    public function getValue(): Money
    {
        return $this->value;
    }
}
