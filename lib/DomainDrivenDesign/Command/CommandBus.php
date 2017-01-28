<?php

declare(strict_types=1);

namespace DomainDrivenDesign\Command;

use DomainDrivenDesign\Exception\MalformedCommandHandlerException;
use DomainDrivenDesign\Exception\NoCommandHandlerSpecifiedException;

final class CommandBus
{
    /** @var CommandHandlerInterface[] */
    private $registry = [];

    public function register(string $commandClassName, CommandHandlerInterface $handler)
    {
        $this->registry[$commandClassName] = $handler;
    }

    public function handle(CommandInterface $command): void
    {
        $commandClassName = get_class($command);
        if (!isset($this->registry[$commandClassName])) {
            throw NoCommandHandlerSpecifiedException::get($commandClassName);
        }
        $handler = $this->registry[$commandClassName];
        if (!is_callable($handler)) {
            throw MalformedCommandHandlerException::notCallable(get_class($handler));
        }

        $handler($command);
    }
}
