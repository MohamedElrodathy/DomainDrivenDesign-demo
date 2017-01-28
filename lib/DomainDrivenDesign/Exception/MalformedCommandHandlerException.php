<?php

declare(strict_types=1);

namespace DomainDrivenDesign\Exception;

use RuntimeException;

final class MalformedCommandHandlerException extends RuntimeException
{
    public static function notCallable(string $commandHandlerClassName): self
    {
        return new self(
            sprintf(
                'The command handler "%s" is not callable. You should define an __invoke(Command $command) method.',
                $commandHandlerClassName
            )
        );
    }
}
