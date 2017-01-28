<?php

declare(strict_types=1);

namespace Product\Domain\Exception;

use Product\Domain\Price;

final class PriceAvailabilityException extends AbstractProductDomainException
{
    public static function priceAlreadyExists(Price $price): PriceAvailabilityException
    {
        throw new self(
            sprintf(
                'You already have a price of %f %s for interval %s -> %s.',
                $price->getValue()->getAmount(),
                $price->getValue()->getCurrency(),
                $price->getAvailableFrom()->format('Y-m-d'),
                $price->getAvailableUntil()->format('Y-m-d')
            )
        );
    }

    public static function tooSoon(int $minimumDays): PriceAvailabilityException
    {
        throw new self(sprintf('You must define your prices %s days before they become available.', $minimumDays));
    }
}
