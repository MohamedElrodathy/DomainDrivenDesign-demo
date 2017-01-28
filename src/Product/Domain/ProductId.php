<?php

declare(strict_types=1);

namespace Product\Domain;

use DomainDrivenDesign\ValueObjectInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ProductId implements ValueObjectInterface
{
    /** @var UuidInterface */
    private $value;

    public function __construct()
    {
        $this->value = Uuid::uuid4();
    }

    public static function fromString(string $productId): ProductId
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

    public function getValue(): UuidInterface
    {
        return $this->value;
    }
}
