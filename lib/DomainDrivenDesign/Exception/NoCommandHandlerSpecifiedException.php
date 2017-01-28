<?php

declare(strict_types=1);

namespace DomainDrivenDesign\Exception;

use RuntimeException;

final class NoCommandHandlerSpecifiedException extends RuntimeException
{
    public static function get($commandClassName): self
    {
        return new self(sprintf('There is no handler able to handle command "%s".', $commandClassName));
    }
}
