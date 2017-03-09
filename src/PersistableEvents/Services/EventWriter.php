<?php

namespace PersistableEvents\Services;

use PersistableEvents\PersistableEvent;
use PersistableEvents\Repositories\EventRepositoryInterface as EventRepository;

class EventWriter
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function store(PersistableEvent $event)
    {
        $this->eventRepository->writeEvent($event);
    }
}
