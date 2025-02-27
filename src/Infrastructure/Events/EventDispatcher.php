<?php

// src/Infrastructure/Event/EventDispatcher.php
namespace App\Infrastructure\Events;

class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, callable $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch($event)
    {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                $listener($event);
            }
        }
    }
}


