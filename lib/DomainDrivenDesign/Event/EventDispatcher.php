<?php

namespace DomainDrivenDesign\Event;

final class EventDispatcher implements EventDispatcherInterface
{
    /** @var array */
    private $listeners = [];

    public function dispatch(EventInterface $event): void
    {
        $listeners = $this->getListeners($event);
        foreach ($listeners as $listener) {

        }
    }

    private function getListeners(EventInterface $event): array
    {
        $eventClassName = get_class($event);
        if (!isset($this->listeners[$eventClassName])) {
            return [];
        }

        return $this->listeners[$eventClassName];
    }
}
