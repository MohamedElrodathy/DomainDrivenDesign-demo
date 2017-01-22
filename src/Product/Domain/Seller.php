<?php

declare(strict_types=1);

namespace Product\Domain;

use DomainDrivenDesign\EntityInterface;

final class Seller implements EntityInterface
{
    /** @var SellerId */
    private $id;
    /** @var string */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function isEqualTo($object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $object->id === $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
