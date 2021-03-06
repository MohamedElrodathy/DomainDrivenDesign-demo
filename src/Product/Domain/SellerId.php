<?php

declare(strict_types=1);

namespace Product\Domain;

use DomainDrivenDesign\ValueObjectInterface;
use Ramsey\Uuid\Uuid;

final class SellerId implements ValueObjectInterface
{
    /** @var \Ramsey\Uuid\UuidInterface */
    private $value;

    public function __construct()
    {
        $this->value = Uuid::uuid4();
    }

    public static function fromString(string $productId): SellerId
    {
        $self = new self();
        $self->value = Uuid::fromString($productId);

        return $self;
    }

    public function isEqualTo($object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $object->value === $this->value;
    }
}
