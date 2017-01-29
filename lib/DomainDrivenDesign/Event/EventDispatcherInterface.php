<?php

declare(strict_types=1);

namespace DomainDrivenDesign\Event;

interface EventDispatcherInterface
{
    public function dispatch(EventInterface $event): void;
}
