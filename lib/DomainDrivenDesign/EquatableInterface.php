<?php

declare(strict_types=1);

namespace DomainDrivenDesign;

interface EquatableInterface
{
    /**
     * Compare current class with another object or variable.
     *
     * @param mixed $object
     *
     * @return bool
     */
    public function isEqualTo($object): bool;
}
