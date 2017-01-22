<?php

declare(strict_types=1);

namespace Product\Domain;

use DomainDrivenDesign\ValueObjectInterface;
use Ramsey\Uuid\Uuid;

final class ProductId implements ValueObjectInterface
{
    /** @var \Ramsey\Uuid\UuidInterface */
    private $value;

    public function __construct()
    {
        $this->value = Uuid::uuid4();
    }

    public function isEqualTo($object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $object->value === $this->value;
    }
}
